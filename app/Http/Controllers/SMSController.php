<?php

namespace App\Http\Controllers;

use App\Account;
use App\Api\GoogleUrl;
use App\Api\Twilio;
use App\Campaign;
use App\Product;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SMSController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postIndex(Request $request)
    {
        $this->validate($request, [
            'campaign_id' => 'required',
            'phoneNumber' => 'required',
        ]);

        $campaign = Campaign::find($request->campaign_id);

        $long_url = url("support/{$campaign->user_id}/{$campaign->product->asin}");
        $short_url = GoogleUrl::getShortURL($long_url);
        $short_url = ($short_url)?$short_url: $long_url;

        $seller_name = "WTC";
        $message = "From {$seller_name}: Please click the link here for a short video on how to leave your review: {$short_url}";

        try {
            Twilio::sendSMS($request->get('phoneNumber') , $message);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }

        return "ok";
    }
}
