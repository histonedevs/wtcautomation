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

Route::get('/', function () {
    return redirect("auth/login");
});

Route::get('/support/{user_id}/{asin}', function($user_id , $asin){
    return view('landing', compact('asin' , 'user_id'));
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'home' => 'Home\HomeController',
    'users' => 'UsersController',
    'download' => 'DownloadController',
    'sms' => 'SMSController',
]);
