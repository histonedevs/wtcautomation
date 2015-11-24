<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
use \Exception;
use Services_Twilio;
use Services_Twilio_TinyHttp;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;


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
        return view('users.sms');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSms(Request $request)
    {
        $request = array(
            'asin' => $request->get('asin'),
            'contact' => $request->get('contact')
        );

        /*$validator = Validator::make(
            array(
                'asin' => $request->get('asin'),
                'contact' => $request->get('contact'),
            ),
            array(
                'asin' => 'required',
                'contact' => 'required|min:4',
            )
        );

        if ($validator->fails())
        {
            Session::flash('message', 'aaa');
            return redirect('users/sms');
        }*/

        try {
            $http = new Services_Twilio_TinyHttp(
                'https://api.twilio.com',
                array('curlopts' => array(
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_SSL_VERIFYHOST => 0,
                ))
            );

            $sid = 'AC184281d4cbd89d7e0fac6e018e4d8200';
            $token = '4396e5ab9328f2f2437448279398c93f';
//            $phoneNumber = '+16092700536';
            $client = new Services_Twilio($sid, $token, "2010-04-01", $http);
            $sms = $client->account->sms_messages->create("+16092700536", "+923139560038", "Welcome", array());

        } catch (Exception $exception) {
            Session::flash('message', $exception->getMessage());
            return redirect('users/sms');
        }

    }
}
