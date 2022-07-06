<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseUserRequest extends FormRequest
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
        // only for PUT/PATCH
        if (isEditMethod($this->request)) {
            $id = (int) $this->request->get('id');

            return [
                'name' => 'required|max:255|unique:users,name,' . $id,
                'email' => 'required|max:255|unique:users,email,' . $id,
                'warehouse_id' => 'required',
                'user_type' => 'required',
                'password' => 'confirmed',
            ];
        }

        return [
            'name'          => 'required',
            'email'          => 'required|unique:users|max:255',
            'password'      => 'required|confirmed',
            'warehouse_id' => 'required',
            'user_type' => 'required'
        ];
    }
}
