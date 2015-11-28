<?php

namespace App\Http\Controllers;

use App\Account;
use App\Api\GoogleUrl;
use App\Api\Twilio;
use App\Product;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SMSController extends Controller
{

    public function getIndex()
    {
        $users = Account::whereParentId(NULL)->get();
        return view('users.sms', compact('users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postIndex(Request $request)
    {
        $this->validate($request, [
            'contact' => 'required',
            'child_users' => 'required',
            'products' => 'required'
        ]);

        $child_user_id = $request->get('child_users');
        $asin = Product::find($request->get('products'))->asin;

        $long_url = url("support/{$child_user_id}/{$asin}");
        $short_url = GoogleUrl::getShortURL($long_url);
        $short_url = ($short_url)?$short_url: $long_url;

        $seller_name = "WTC";
        $message = "From {$seller_name}: Please click the link here for a short video on how to leave your review: {$short_url}";

        try {
            Twilio::sendSMS($request->get('contact') , $message);
            Session::flash('success', 'Successfully Send SMS');
        } catch (Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }

        return $this->getIndex();
    }
}
