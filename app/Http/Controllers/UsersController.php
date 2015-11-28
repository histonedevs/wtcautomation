<?php

namespace App\Http\Controllers;

use App\Api\GoogleUrl;
use App\Api\Twilio;
use App\Api\UrlShortenerApi;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
use \Exception;
use Services_Twilio;
use Services_Twilio_TinyHttp;
use Illuminate\Support\Facades\Session;
use \Validator;
use App\Account;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function postAdd(Request $request)
    {
        $user = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        );

        User::create($user);
        return redirect('users/index');
    }

    public function getAdd()
    {
        return view('users.add_user');
    }

    public function getDelete($id){
        User::find($id)->delete();
        return redirect('users/index');
    }

    public function getEdit($id)
    {
        $user = User::find($id);
        return view('users.edit_user', compact('user'));
    }

    public function postEdit(Request $request, $id)
    {
        $request = array(
            'name' => $request->get('name'),
            'email' => $request->get('email')
        );
        $user = User::find($id);
        $user->update($request);
        return redirect('users/index');
    }

    public function getSms()
    {
        $users = Account::whereParentId(NULL)->get();
        return view('users.sms', compact('users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSms(Request $request)
    {
        $this->validate($request, [
            'contact' => 'required',
            'child_users' => 'required',
            'products' => 'required'
        ]);

        $child_user_id = $request->get('child_users');
        $asin = Product::find($request->get('products'))->asin;

        $short_url = GoogleUrl::getShortURL(url("support/{$child_user_id}/{$asin}"));

        try {
            Twilio::sendSMS($request->get('contact') , $short_url);
            Session::flash('success', 'Successfully Send SMS');
        } catch (Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        return redirect('users/sms');
    }
}
