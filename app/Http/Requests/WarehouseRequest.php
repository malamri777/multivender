<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
                // 'name'                  => 'required|max:255|unique:warehouses,name,' . $id,
                // 'country_id'            => 'required',
                'state_id'              => 'required',
                'city_id'               => 'required',
                'district_id'           => 'required',

            ];
        }

        return [
            // 'name'                  => 'required|unique:warehouses|max:255',
            // 'country_id'            => 'required',
            'state_id'              => 'required',
            'city_id'               => 'required',
            'district_id'           => 'required',

        ];


    }
}
