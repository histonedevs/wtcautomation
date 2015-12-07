<?php
/**
 * Created by PhpStorm.
 * User: histone
 * Date: 28/11/15
 * Time: 2:33 PM
 */

namespace App\Api;


use Lookups_Services_Twilio;
use Services_Twilio;
use Services_Twilio_TinyHttp;

class Twilio
{
    public static function lookup($phoneNumber , $countryCode){
        $client = new Lookups_Services_Twilio(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        $number = $client->phone_numbers->get($phoneNumber, [
            "CountryCode" => $countryCode,
            "Type" => "carrier"
        ]);
        return $number->carrier;
    }


    public static function sendSMS($to, $message){
        $http = new Services_Twilio_TinyHttp(
            'https://api.twilio.com',
            array('curlopts' => array(
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
            ))
        );

        $client = new Services_Twilio(
            env('TWILIO_SID'),
            env('TWILIO_TOKEN'), "2010-04-01",
            $http
        );

        return $client->account->sms_messages->create(env('TWILIO_SENDER'), $to, $message, array());
    }
}