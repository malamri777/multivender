<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUserRequest extends FormRequest
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
            // $validationArr = [];

            // $validationArr['name'] = 'required|max:255|unique:users,name,' . $id;
            // $validationArr['email'] = 'required|max:255|unique:users,email,' . $id;
            // $validationArr['supplier_id'] = 'required';
            // $validationArr['user_type'] = 'required';
            // $validationArr['old_password'] = 'required_with:password,value';
            // $validationArr['password'] = 'confirmed';
            // return $validationArr;

            return [
                'name' => 'required|max:255|unique:users,name,' . $id,
                'email' => 'required|max:255|unique:users,email,' . $id,
                'supplier_id' => 'required',
                'roleIds' => 'required',
                'password' => 'confirmed',
            ];
        }

        return [
            'name'          => 'required',
            'email'          => 'required|unique:users|max:255',
            'password'      => 'required|confirmed',
            'supplier_id' => 'required',
            'roleIds' => 'required'
        ];
    }
}
