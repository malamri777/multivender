<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
                'name'          => 'required|max:255|unique:suppliers,name,' . $id,
                'cr_no'         => 'required|unique:suppliers,cr_no,' . $id,
                'vat_no'        => 'required|unique:suppliers,vat_no,' . $id,
                'email'         => 'required|email',
                'logo'          => 'required',

            ];
        }

        return [
            'name'          => 'required|unique:suppliers|max:255',
            'cr_no'         => 'required|unique:suppliers',
            'vat_no'        => 'required|unique:suppliers',
            'email'         => 'required|email',
            'logo'          => 'required',

        ];


    }
}
