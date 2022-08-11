<?php

namespace App\Utility;

use App\Models\OtpConfiguration;
use App\Models\User;
use App\Utility\MimoUtility;
use Cache;
use Carbon\Carbon;
use Twilio\Rest\Client;

class WathqUtility
{
    public static function sendRequest($cr_id)
    {


        $url = "https://api.wathq.sa/v4/commercialregistration/info/" . $cr_id;

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'accept:application/json',
            'apiKey:LyRZGuXQYiAxAeybMG3kdcEdJCGQtoGQ'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $response_json = json_decode($response, true);

        $result = [
            'success' => false,
            'message' => '',
            'data' => null,
        ];

        $errArray = ['429.1.1', '404.2.1', '400.2.1'];
        if(!empty($response_json['code']) and in_array($response_json['code'], $errArray)) {
            $result['message'] = $response_json['message'];
        } else {
            $result['success'] = true;
            $result['data'] = $response_json;
        }

        return $result;
    }
}
