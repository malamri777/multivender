<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Log;

class RestaurantUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (isEditMethod($this->request)) {
            // $validationArr = [];

            // $validationArr['name'] = 'required|max:255|unique:users,name,' . $id;
            // $validationArr['email'] = 'required|max:255|unique:users,email,' . $id;
            // $validationArr['restaurant_id'] = 'required';
            // $validationArr['user_type'] = 'required';
            // $validationArr['old_password'] = 'required_with:password,value';
            // $validationArr['password'] = 'confirmed';
            // return $validationArr;

            return [
                'name' => 'required|max:255|unique:users,name,' . Auth::id(),
                'email' => 'required|max:255|unique:users,email,' . Auth::id(),
                // 'restaurant_id' => 'required',
                // 'password' => 'confirmed',
            ];
        }

        return [
            'name'          => 'required',
            'email'          => 'required|unique:users|max:255',
            // 'password'      => 'required|confirmed',
            // 'restaurant_id' => 'required'
        ];
    }
}
