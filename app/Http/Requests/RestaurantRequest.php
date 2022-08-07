<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
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
            $id = (int) $this->request->get('id');
            return [
                'name'          => 'required|max:255|unique:restaurants,name,' . $id,
                'cr_no'         => 'required|unique:restaurants,cr_no,' . $id,
                'vat_no'        => 'required|unique:restaurants,vat_no,' . $id,
                'email'         => 'required|email',
                'logo'          => 'required',
                // 'cr_file'    => 'required',
                // 'vat_file'   => 'required',
            ];
        }

        return [
            'name'          => 'required|unique:restaurants|max:255',
            'cr_no'         => 'required|unique:restaurants',
            'vat_no'        => 'required|unique:restaurants',
            'email'         => 'required|email',
            'logo'          => 'required',
            'cr_file'    => 'required',
            'vat_file'   => 'required',

        ];


    }
}
