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
            make_column('product_title', 'products.title', 'Product Title', 'text'),
            make_column('campaign_name' , 'campaigns.name', 'Campaign Name', 'text'),
//            make_column('sms', null, '', null, [], '<a class="btn btn-primary sendSmsBtn" href="#" campaign_id="{{$id}}">Send SMS</a>', null, '0px', null, false),
        ];

        $base_query = DB::table('negative_responses')->select(
            [   'negative_responses.id', 'negative_responses.customer_name as customer_name',
                'negative_responses.customer_email as customer_email',
                'campaigns.name as campaign_name', 'products.title as product_title']
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        print "An Email Has Been Sent to Manager. Thanks";
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

        print "Sent to your email. Thanks";
    }
}
