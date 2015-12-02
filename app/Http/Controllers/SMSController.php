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
        $sms_text = Variable::where('name','campaign_sms_text')->first();

        $message = $sms_text->value;
        $message = str_replace("[COMPANY_NAME]" , $campaign->user->company_name , $message);
        $message = str_replace("[URL]" , $short_url , $message);

        $stored_msg = Message::create([
            'user_id' => $this->user->id,
            'recipient' => $request->get('phoneNumber'),
            'product_id' => $campaign->product->id,
            'text' => $message,
        ]);

        try {
            Twilio::sendSMS($request->get('phoneNumber') , $message);
            $stored_msg->sent = 1;
            $stored_msg->save();
        } catch (Exception $exception) {
            $stored_msg->error = $exception->getMessage();
            return $exception->getMessage();
        }

        return "ok";
    }
}
