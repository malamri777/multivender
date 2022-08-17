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
        if (!empty($response_json['code']) and in_array($response_json['code'], $errArray)) {
            $result['message'] = $response_json['message'];
        } else {
            $result['success'] = true;
            $result['data'] = $response_json;
        }

        return $result;
    }

    public static function testData()
    {
        return  [
            'success' => true,
            'data' => array(
                'crName' => 'Test',
                'crNumber' => '1111111111',
                'crEntityNumber' => '700XXXX660',
                'issueDate' => '1391/10/19',
                'expiryDate' => '1444/04/04',
                'crMainNumber' => NULL,
                'businessType' =>
                array(
                    'id' => '205',
                    'name' => 'مســــــــــاهمة',
                ),
                'fiscalYear' =>
                array(
                    'month' => 2,
                    'day' => 1,
                    'calendarType' =>
                    array(
                        'id' => 1,
                        'name' => 'هجري',
                    ),
                ),
                'status' =>
                array(
                    'id' => 'active',
                    'name' => 'السجل التجاري قائم',
                    'nameEn' => 'السجل التجاري قائم',
                ),
                'cancellation' =>
                array(
                    'date' => '1440/05/01',
                    'reason' => 'تم الغاء السجل بسب...',
                ),
                'location' =>
                array(
                    'id' => '1010',
                    'name' => 'الرياض',
                ),
                'company' =>
                array(
                    'period' => '10',
                    'startDate' => '1439/01/12',
                    'endDate' => '1449/01/12,',
                ),
                'activities' =>
                array(
                    'description' => 'البيع بالجملة و التجزئة للحبوب والبذور',
                    'isic' =>
                    array(
                        0 =>
                        array(
                            'id' => '477211',
                            'name' => 'أنشطة المواد الغذائية',
                            'nameEn' => NULL,
                        ),
                    ),
                ),
            )
        ];
    }
}
