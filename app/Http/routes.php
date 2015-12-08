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
    $asin = $message->campaign->product->asin;
    $account = $message->campaign->user;

    $message->visited_at = \Carbon\Carbon::now();
    $message->save();

    $marketplace_id = $account->marketplace->marketplace_id;
    $seller_id = $account->merchant_id;

    return view('landing', compact('asin' , 'account', 'marketplace_id' , 'seller_id'));
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
]);
