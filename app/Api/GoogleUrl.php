<?php
/**
 * Created by PhpStorm.
 * User: Faheem
 * Date: 11/26/2015
 * Time: 7:05 PM
 */

namespace App\Api;


class GoogleUrl
{
    public static function getShortURL($long_url){
        $short_url = new GoogleUrl();
        $short_url->getGoogleURLAPI(env("API_KEY"));
        return $short_url->getShorten($long_url);
    }


    public function getGoogleURLAPI($key, $apiURL = 'https://www.googleapis.com/urlshortener/v1/url'){
        // Keep the API Url
        $this->apiURL = $apiURL.'?key='.$key;
    }

    public function getShorten($url) {
        // Send information along
        $response = $this->send($url);
        // Return the result
        return isset($response['id']) ? $response['id'] : false;
    }

    public function getExpand($url) {
        // Send information along
        $response = $this->send($url,false);
        // Return the result
        return isset($response['longUrl']) ? $response['longUrl'] : false;
    }

    function send($url,$shorten = true) {
        // Create cURL
        $ch = curl_init();
        // If we're shortening a URL...
        if($shorten) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt($ch,CURLOPT_URL,$this->apiURL);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode(array("longUrl"=>$url)));
            curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json"));
        }
        else {
            curl_setopt($ch,CURLOPT_URL,$this->apiURL.'&shortUrl='.$url);
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        // Execute the post
        $result = curl_exec($ch);
        // Close the connection
        curl_close($ch);
        // Return the result
        return json_decode($result,true);
    }
}