<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseProductReqeust extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'price' => 'required|numeric',
            'sale_price' => 'numeric',
            'quantity' => 'required|numeric',
            'warehouse_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'create_by_id' => 'required|numeric',
            'updated_by_id' =>  'required|numeric'
        ];
    }
}
