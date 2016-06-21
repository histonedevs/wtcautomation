<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Account;

Route::get('/', function () {
    return redirect("auth/login");
});

Route::get('/r/{message_id}', function($message_id){

    $message = \App\Message::find($message_id);
    $account = $message->campaign->user;

    $message->visited_at = \Carbon\Carbon::now();
    $message->save();

    return view('feedback.landing', compact('account', 'message'));
});

Route::get('/v/{message_id}/{stars}', function($message_id , $stars){
    $message = \App\Message::find($message_id);
    $asin = $message->campaign->product->asin;

    $account = $message->campaign->user;
    $amazon_url = $account->marketplace->amazon_url;
    $amazon_url = str_replace('http://' , 'https://', $amazon_url);

    $marketplace_id = $account->marketplace->marketplace_id;
    $seller_id = $account->merchant_id;

    $message->stars = $stars;
    $message->save();

    if($stars == '5' || $stars == '4'){
        return redirect("{$amazon_url}/review/review-your-purchases?ie=UTF8&asins={$asin}&channel=awReviews&ref_=aw_cr_write_cr#");
    }else{
        return redirect("{$amazon_url}/gp/help/contact/contact.html?ie=UTF8&asin={$asin}&isCBA=&marketplaceID={$marketplace_id}&orderID=&ref_=aag_d_sh&sellerID={$seller_id}");
    }
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'home' => 'Home\HomeController',
    'users' => 'UsersController',
    'download' => 'DownloadController',
    'sms' => 'SMSController',
    'campaigns' => 'CampaignController',
    'accounts' => 'AccountController',
    'settings' => 'SettingsController',
    'feedback' => 'FeedbackController'
]);
