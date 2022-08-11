<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OTPVerificationController;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class RestaurantUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:restaurant_admin')->only(['findUser','assignUserToRestaurant']);
    }

    public function findUser(Request $request)
    {
        $phone = $request->phone;
        $country_dial_code = $request->country_dial_code;
        $country_code = $request->country_code;

        if(empty($phone) or empty($country_dial_code) or empty($country_code)) {
            $result = [
                "status" => false,
                "message" => "Failed Operations",
            ];
        }
        $user = User::where(['phone' => $phone, 'country_code' => $country_code, 'country_dial_code' => $country_dial_code])
            ->first();

        $user->otp_code = otpGenerater();
        $user->otp_code_count = 0;
        $user->otp_code_time_amount_left = now();
        $user->save();

        $result = [
            "status" => true,
            "message" => "OTP has send to the user",
            'uuid' => $user->uuid
        ];

        if (config('myenv.OTP_DEBUG_ENABLE') == 'on') {
            $result['otp_code'] = $user->otp_code;
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        return response()->json($result, 200);
    }

    public function assignUserToRestaurant(User $user)
    {
        $user->restaurant_id = Auth::user()->restaurant_id;
        return response()->json([
            "status" => true
        ], 200);
    }

}
