<?php

namespace App\Http\Controllers;

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
use App\UrlShortenerApi;


class UsersController extends Controller
{
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

    public function getDelete($id)
    {
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
            'asin' => 'required',
            'contact' => 'required'
        ]);

        $parent_user_id = $request->get('users');
        $child_user_id = $request->get('child_users');
        $product_id = $request->get('products');
        $asin = $request->get('asin');
        $this->getLanding($parent_user_id, $child_user_id, $product_id, $asin);
        $url = url("users/landing/");
        $url .= "/" . $parent_user_id . "/" . $child_user_id . "/" . $product_id . "/" . $asin;

        $short_url = new UrlShortenerApi();
        $short_url->getGoogleURLAPI(env("API_KEY"));
        $shortDWName = $short_url->getShorten($url);
//        echo $shortDWName;
        try {
            $http = new Services_Twilio_TinyHttp(
                'https://api.twilio.com',
                array('curlopts' => array(
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_SSL_VERIFYHOST => 0,
                ))
            );

            $client = new Services_Twilio(env('TWILIO_SID'), env('TWILIO_TOKEN'), "2010-04-01", $http);
            $sms = $client->account->sms_messages->create("+12267741565", $request->get('contact'), $request->get('asin') . " " . $shortDWName, array());
            Session::flash('success', 'Successfully Send SMS');
            return redirect('users/sms');
        } catch (Exception $exception) {
            Session::flash('error', $exception->getMessage());
            return redirect('users/sms');
        }
    }

    public function getLanding($parent_user, $child_user, $product, $asin)
    {
        $product = Product::find($product);
        return view('users.landing', compact('product'));
    }
}
