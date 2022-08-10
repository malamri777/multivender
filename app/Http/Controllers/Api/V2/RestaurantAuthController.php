<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\OTPVerificationController;
use App\Http\Requests\Api\Auth\RestaurantSignUpRequest;
use App\Http\Requests\RestaurantUserRequest;
use App\Http\Resources\V2\RestaurantUserResource;
use App\Models\BusinessSetting;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\AppEmailVerificationNotification;
use App\Utility\SendSMSUtility;
use Auth;
use Hash;
use Socialite;



class RestaurantAuthController extends Controller
{

    // Not Used
    public function signup(RestaurantSignUpRequest $request)
    {
        $existingUser = User::where('phone', $request->phone)->first();
        if ($existingUser or !checkerCountryCode($request)) {
            return response()->json([
                'result' => false,
                'message' => translate('Error Creating User'),
                'user_id' => 0
            ], 401);
        } else {
            $user = new User([
                'name' => $request->name,
                'phone' => $request->phone,
                'country_dial_code' => $request->country_dial_code,
                'country_code' => $request->country_code,
                'email' => $request->email,
                'user_type' => 'restaurant',
                // 'password' => bcrypt($request->password),
                'otp_code' => otpGenerater()
            ]);
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

        $role = Role::where('name', 'registered')->first();
        $user->roles()->sync($role);

        //create token
        $user->createToken('tokens')->plainTextToken;
        $result = [
            'result' => true,
            'message' => translate('Registration Successful. Please verify and log in to your account.'),
            'uuid' => $user->uuid
        ];

        if(config('myenv.OTP_DEBUG_ENABLE') == 'on') {
            $result['otp_code'] = $user->otp_code;
        }

        return response()->json($result, 201);
    }

    public function resendCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->otp_code = otpGenerater();

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
            'otp_code' => 'required'
        ]);
        $user = User::where('uuid', $request->uuid)
            ->first();

        if ($user->otp_code == null) {
            return response()->json([
                'result' => false,
                'message' => translate('Pleae Login again.'),
            ], 401);
        }

        if($user && SendSMSUtility::isOTPVaild($user) == SendSMSUtility::OK) {
            if ($user->otp_code == $request->otp_code) {
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();

                return $this->loginSuccess($user);
                // return response()->json([
                //     'result' => true,
                //     'message' => translate('Your account is now verified.Please login'),
                // ], 200);
            } else {
                $user->increment('otp_code_count', 1);
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
            // 'password' => 'required|string'
        ]);

        $user = User::wherehas('roles', function($q){
            $q->whereIn('name', restaurantRolesList());
        })
        ->where('phone', $request->phone)->first();


        if ($user != null) {
            // if (Hash::check($request->password, $user->password)) {

                if ($user->email_verified_at == null) {
                    return response()->json(['message' => translate('Please verify your account'), 'user' => null], 401);
                }

                $user->otp_code = otpGenerater();
                $user->otp_code_count = 0;
                $user->otp_code_time_amount_left = now();
                $user->save();
                // return $this->loginSuccess($user);
                $result = [
                    'message' => translate('Code sent to your phone.'),
                    'uuid' => $user->uuid
                ];
                if (config('myenv.OTP_DEBUG_ENABLE') == 'on') {
                    $result['otp_code'] = $user->otp_code;
                }
                return response()->json($result);

            // } else {
            //     return response()->json(['result' => false, 'message' => translate('Unauthorized'), 'user' => null], 401);
            // }
        } else {
            $user = new User([
                'phone' => $request->phone,
                'country_dial_code' => $request->country_dial_code,
                'country_code' => $request->country_code,
            ]);

            $user->otp_code = otpGenerater();
            $user->otp_code_count = 0;
            $user->otp_code_time_amount_left = now();
            $user->save();

            $result = [
                'message' => translate('Code sent to your phone.'),
                'uuid' => $user->uuid
            ];

            if (config('myenv.OTP_DEBUG_ENABLE') == 'on') {
                $result['otp_code'] = $user->otp_code;
            }
            return response()->json($result);
        }
    }

    public function user(Request $request)
    {
        $user = User::with('restaurant')->where('id', $request->user()->id)->first();
        $restaurantUser = new RestaurantUserResource($user);
        return $restaurantUser;
    }


    protected function loginSuccess($user)
    {
        $token = $user->createToken('API Token')->plainTextToken;
        $result = [
            'result' => true,
            'message' => translate('Successfully logged in'),
            'access_token' => 'Bearer ' . $token,
            'expires_at' => null,
            'user' => RestaurantUserResource::make($user)
        ];

        if (config('myenv.OTP_DEBUG_ENABLE') == 'on') {
            $result['otp_code'] = $user->otp_code;
        }

        $user->otp_code = null;
        $user->otp_code_count = 0;
        $user->otp_code_time_amount_left = null;
        $user->save();

        return response()->json([
            "status" => true,
            "data" => $result
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged out')
        ]);
    }

    public function userUpdate(RestaurantUserRequest $request)
    {
        $user = Auth::user();
        $user->update($request->except(['phone', '']));

        return RestaurantUserResource::make($user);
    }
}
