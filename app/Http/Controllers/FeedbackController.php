<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Datatables;
use yajra\Datatables\Html\Builder;
use App\Message;
use App\NegativeResponse;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request, Builder $htmlBuilder, $user_id = Null)
    {
        $columns = [
            make_column('customer_name', 'negative_responses.customer_name', 'Customer Name', 'text'),
            make_column('customer_email', 'negative_responses.customer_email', 'Customer Email' , 'text'),
            make_column('customer_mobile', 'messages.recipient', 'Customer Mobile' , 'text'),
            make_column('reason', 'negative_responses.reason', 'Reason', 'text'),
            make_column('suggestion', 'negative_responses.suggestion', 'Suggestion' , 'text'),
            make_column('product_asin', 'products.asin', 'ASIN', 'text'),
            make_column('campaign_name' , 'campaigns.name', 'Campaign Name', 'text'),
            make_column('created_at' , 'negative_responses.created_at', 'Date', 'text'),
//            make_column('sms', null, '', null, [], '<a class="btn btn-primary sendSmsBtn" href="#" campaign_id="{{$id}}">Send SMS</a>', null, '0px', null, false),
        ];

        $base_query = DB::table('negative_responses')->select(
            [   'negative_responses.id', 'negative_responses.customer_name as customer_name',
                'negative_responses.customer_email as customer_email', 'messages.recipient as customer_mobile',
                'negative_responses.reason as reason', 'negative_responses.suggestion as suggestion',
                'negative_responses.created_at as created_at',
                'campaigns.name as campaign_name', 'products.asin as product_asin']
        )
            ->join('messages', 'negative_responses.message_id' , '=' , 'messages.id')
            ->join('campaigns', 'messages.campaign_id' , '=' , 'campaigns.id')
            ->join('products', 'campaigns.product_id' , '=' , 'products.id');

        if($user_id){
            $base_query->join('accounts', 'campaigns.user_id' , '=' , 'accounts.id')
                ->where(function($query) use($user_id){
                    $query->where('campaigns.user_id',$user_id)
                        ->orWhere('accounts.parent_id',$user_id);
                });
        }

        if($this->isAjax($request)){
            return $this->dataTable($columns, $request , Datatables::of($base_query))->make(true);
        } else{
            $data_table = build_data_table($htmlBuilder , $columns , $base_query , url('feedback/index/'.$user_id));
            return view('feedback.index', compact('data_table'));
        }
    }

    public function getRecommended($message_id)
    {
        $message = Message::find($message_id);
        $account = $message->campaign->user;
        return view('feedback.recommended', compact('account', 'message_id'));
    }

    public function getRejected($message_id)
    {
        $message = Message::find($message_id);
        $account = $message->campaign->user;
        return view('feedback.rejected', compact('account', 'message_id'));
    }

    public function postSendFeedback(Request $request)
    {
        $this->validate($request, [
            'reason' => 'required',
            'name' => 'required',
            'email' => 'required',
            'message_id' => 'required'
        ]);

        $negResponse = new NegativeResponse;

        $negResponse->message_id = $request->message_id;
        $negResponse->customer_name = $request->name;
        $negResponse->customer_email = $request->email;
        $negResponse->reason = $request->reason;
        $negResponse->suggestion = $request->suggestion;

        $negResponse->save();

        $message = Message::find($request->message_id);
        $account = $message->campaign->user;

        // Send feedback in E-mail
        Mail::send('feedback.email.response', ['feedback' => $request, 'campaign' => $message->campaign],
            function ($message) use ($request, $account) {
                $message
                    ->from($request->email, $request->name)
                    ->to($account->contact_email, $account->name)
                    ->subject('Customer Feedback');
            }
        );

        print "<h3>An Email Has Been Sent to Manager. Thanks</h3>";
    }

    public function postEmailFeedback(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'message_id' => 'required'
        ]);

        $message = Message::find($request->message_id);
        $account = $message->campaign->user;

        // Send feedback in E-mail
        Mail::send('feedback.email.link', ['message_id' => $request->message_id],
            function ($message) use ($request, $account) {
                $message
                    ->to($request->get('email'), '')
                    ->subject('Campaign Feedback');
            }
        );

        print "<h3>Sent to your email. Thanks</h3>";
    }
}
