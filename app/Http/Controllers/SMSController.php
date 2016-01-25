<?php

namespace App\Http\Controllers;

use App\Account;
use App\Api\GoogleUrl;
use App\Api\Twilio;
use App\Campaign;
use App\Message;
use App\Product;
use App\Variable;
use Exception;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Datatables;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Laracasts\Flash\Flash;
use yajra\Datatables\Html\Builder;

class SMSController extends Controller
{
    use FormBuilderTrait;

    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getCarrier(Request $request){
        $this->validate($request, [
            'phoneNumber' => 'required',
        ]);

        $carrier = Twilio::lookup($request->phoneNumber);
        if($carrier->type != "mobile"){
            return "This is not a mobile number";
        }

        return "ok";
    }

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

        /*
        $carrier = Twilio::lookup($request->phoneNumber);
        if($carrier->type != "mobile"){
            return "This is not a mobile number";
        }
        */

        $campaign = Campaign::find($request->campaign_id);

        $stored_msg = Message::create([
            'user_id' => Auth::user()->id,
            'recipient' => $request->get('phoneNumber'),
            'campaign_id' => $campaign->id,
        ]);

        $long_url = url("r/{$stored_msg->id}");
        //$short_url = GoogleUrl::getShortURL($long_url);
        //$short_url = ($short_url)?$short_url: $long_url;
        $short_url = $long_url;

        $sms_text = Variable::where('name','campaign_sms_text')->first();
        $message = $sms_text->value;
        $message = str_replace("[COMPANY_NAME]" , $campaign->user->company_name , $message);
        $message = str_replace("[URL]" , $short_url , $message);

        $stored_msg->text = $message;
        $stored_msg->visited_at = null;

        try {
            Twilio::sendSMS($request->get('phoneNumber') , $message);
            $stored_msg->sent = 1;
            $stored_msg->save();
        } catch (Exception $exception) {
            $stored_msg->error = $exception->getMessage();
            $stored_msg->save();
            return $exception->getMessage();
        }

        return "ok";
    }

    /**
     * @param Request $request
     * @param Builder $htmlBuilder
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request, Builder $htmlBuilder){
        if(Auth::user()->user_type != 'admin'){
            return redirect(url('home'));
        }
        $columns = [
            make_column('user_name', 'users.name', 'Sender' , 'text'),
            make_column('recipient' , 'messages.recipient', 'Recipient', 'text'),
            make_column('campaign_name', 'campaigns.name', 'Campaign' , 'text'),
            make_column('text' , 'messages.text', 'SMS', 'text'),
            make_column('created_at' , 'messages.created_at', 'Sent at', 'text'),
            make_column('visited_at' , 'messages.visited_at', 'Visited', 'text',[],function($record){
                if($record->visited_at && $record->visited_at != '0000-00-00 00:00:00') {
                    return $record->visited_at;
                }else{
                    return 'Not visited';
                }
            }),
            make_column('stars' , 'messages.stars', 'Stars', 'number'),
        ];

        $base_query = DB::table('messages')->select('messages.*','campaigns.name as campaign_name','users.name as user_name')
            ->join('campaigns', 'messages.campaign_id' , '=', 'campaigns.id')
            ->join('users', 'messages.user_id' , '=', 'users.id');

        if($this->isAjax($request)){
            return $this->dataTable($columns, $request , Datatables::of($base_query))->make(true);
        }else{
            $data_table = build_data_table($htmlBuilder , $columns , $base_query , url('sms'));
            return view('accounts.index', compact('data_table'));
        }

    }

    public function getIndustryFirst(){
        $form = $this->form('App\Forms\IndustryFirstForm', ['method' => 'POST']);
        return view('sms.industry_first', compact('form'));
    }

    public function postIndustryFirst(Request $request){
        $form = $this->form('App\Forms\IndustryFirstForm', ['method' => 'POST']);
        if($form->validate()){
            try {
                Twilio::sendSMS($request->get('recipient') , $request->get('sms_text'), $request->get('sender'));
                Session::flash('success', "Sent");
            } catch (Exception $exception) {
                Session::flash('error', $exception->getMessage());
            }
        }

        return view('sms.industry_first', compact('form'));
    }
}
