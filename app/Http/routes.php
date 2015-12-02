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

Route::get('/support/{user_id}/{asin}', function($user_id , $asin){
    $account = Account::find($user_id);

    return view('landing', compact('asin' , 'account'));
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
