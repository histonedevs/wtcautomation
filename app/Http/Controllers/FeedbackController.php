<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Message;
use App\NegativeResponse;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        /*
        $message = Message::find($request->message_id);
        $account = $message->campaign->user;

        // Send feedback in E-mail
        Mail::send('feedback.email', ['feedback' => $request, 'campaign' => $message->campaign],
            function ($message) use ($request, $account) {
                $message
                    ->from($request->email, $request->name)
                    ->to($account->email, $account->name)
                    ->subject('Customer Feedback');
            }
        );
        
        */
        return redirect('/');
    }
}
