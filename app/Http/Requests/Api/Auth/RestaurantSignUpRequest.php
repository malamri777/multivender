<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantSignUpRequest extends FormRequest
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
        return [
            'name'              => 'required',
            'email'             => 'required|unique:users|max:255',
            'phone'             => 'required|numeric|phone_number|digits_between:8,10',
            'country_code'      => 'required|numeric|digits_between:2,3',
            'password'          => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => translate('Name is required'),
            'email.required'            => translate('Email is required'),
            'email.unique'              => translate('Email is already register in the system'),
            'email.max'                 => translate('Max Char For Email is 255'),
            'phone.required'            => translate('Phone is required'),
            'phone.numeric'             => translate('Phone must be numeric'),
            'phone.phone_number'        => translate('Enter Phone without leading 0'),
            'phone.min'                 => translate('Phone must be greater than 7 digit'),
            'phone.max'                 => translate('Phone must be leass than 11 digit'),
            'country_code.required'     => translate('Country Code is required'),
            'country_code.numeric'      => translate('Country Code must be numeric'),
        ];
    }
}
