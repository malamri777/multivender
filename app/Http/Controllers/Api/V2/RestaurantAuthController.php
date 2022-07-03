<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\OTPVerificationController;
use App\Models\BusinessSetting;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\AppEmailVerificationNotification;
use App\Utility\SendSMSUtility;
use Hash;
use Socialite;



class RestaurantAuthController extends Controller
{
    public function signup(Request $request)
    {
        $existingUser = User::where('phone', $request->phone)->first();
        if (!$existingUser) {
            $user = new User([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_type' => 'restaurant',
                'password' => bcrypt($request->password),
                'verification_code' => rand(100000, 999999)
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => translate('User already exists.'),
                'user_id' => 0
            ], 201);
        }

        // if (User::where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first() != null) {
        //     return response()->json([
        //         'result' => false,
        //         'message' => translate('User already exists.'),
        //         'user_id' => 0
        //     ], 201);
        // }

        $user->email_verified_at = null;
        if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
        }

        if($user->email_verified_at == null){
            if ($request->register_by == 'email') {
                try {
                    $user->notify(new AppEmailVerificationNotification());
                } catch (\Exception $e) {
                }
            } else {
                $otpController = new OTPVerificationController();
                if(!SendSMSUtility::userHasVaildOTP($user)) {
                    $otpController->send_code($user);
                }
            }
        }

        $user->save();

        //create token
        $user->createToken('tokens')->plainTextToken;
        $result = [
            'result' => true,
            'message' => translate('Registration Successful. Please verify and log in to your account.'),
            // 'user_id' => $user->id
        ];

        if(config('myenv.OTP_DEBUG_ENABLE') == 'on') {
            $result['otp_code'] = $user->verification_code;
        }

        return response()->json($result, 201);
    }

    public function resendCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->verification_code = rand(100000, 999999);

        if ($request->verify_by == 'email') {
            $user->notify(new AppEmailVerificationNotification());
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        $user->save();

        return response()->json([
            'result' => true,
            'message' => translate('Verification code is sent again'),
        ], 200);
    }

    public function confirmCode(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'verification_code' => 'required'
        ]);
        $user = User::where('uuid', $request->uuid)
            ->first();

        if ($user->verification_code == null) {
            return response()->json([
                'result' => false,
                'message' => translate('Pleae Login again.'),
            ], 401);
        }

        if($user && SendSMSUtility::isOTPVaild($user) == SendSMSUtility::OK) {
            if ($user->verification_code == $request->verification_code) {
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();

                return $this->loginSuccess($user);
                // return response()->json([
                //     'result' => true,
                //     'message' => translate('Your account is now verified.Please login'),
                // ], 200);
            } else {
                $user->increment('verification_code_count', 1);
                return response()->json([
                    'result' => false,
                    'message' => translate('Code does not match, you can request for resending the code'),
                ], 401);
            }
        } else {
            return response()->json([
                'result' => false,
                'message' => translate('Error: User is not exist or you have an expire Code'),
            ], 401);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|string'
        ]);

        $user = User::whereIn('user_type', ['restaurant_admin', 'restaurant_branch_admin', 'restaurant'])->where('phone', $request->phone)->first();


        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {

                if ($user->email_verified_at == null) {
                    return response()->json(['message' => translate('Please verify your account'), 'user' => null], 401);
                }

                $user->verification_code = rand(100000, 999999);
                $user->verification_code_count = 0;
                $user->verification_code_time_amount_left = now();
                $user->save();
                // return $this->loginSuccess($user);
                $result = [
                    'message' => translate('Code sent to your phone.'),
                    'uuid' => $user->uuid
                ];
                if (config('myenv.OTP_DEBUG_ENABLE') == 'on') {
                    $result['otp_code'] = $user->verification_code;
                }
                return response()->json($result);

            } else {
                return response()->json(['result' => false, 'message' => translate('Unauthorized'), 'user' => null], 401);
            }
        } else {
            return response()->json(['result' => false, 'message' => translate('User not found'), 'user' => null], 401);
        }
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }


    protected function loginSuccess($user)
    {
        $token = $user->createToken('API Token')->plainTextToken;
        $result = [
            'result' => true,
            'message' => translate('Successfully logged in'),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => null,
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'avatar_original' => uploaded_asset($user->avatar_original),
                'phone' => $user->phone
            ]
        ];

        if (config('myenv.OTP_DEBUG_ENABLE') == 'on') {
            $result['otp_code'] = $user->verification_code;
        }

        $user->verification_code = null;
        $user->verification_code_count = 0;
        $user->verification_code_time_amount_left = null;
        $user->save();

        return response()->json([
            "status" => true,
            "data" => $result
        ], 301);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged out')
        ]);
    }
}