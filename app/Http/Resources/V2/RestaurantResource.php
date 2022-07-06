<?php

namespace App\Http\Resources\V2;

use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "cr_no" => $this->cr_no,
            "vat_no" => $this->vat_no,
            "email" => $this->email,
            "phone" => $this->phone,
            "contact_user" => $this->contact_user,
            "description" => $this->description,
            "content" => $this->content,
            "logo" => uploaded_asset($this->logo),
            "status" => $this->status ? true : false,
            "restaurant_waiting_for_upload_file" => $this->restaurant_waiting_for_upload_file ? true : false,
            "restaurant_waiting_for_admin_approve" => $this->restaurant_waiting_for_admin_approve ? true : false,
            "admin" => $this->when(Auth::id(), 'admin_id'),
            "cr_file" => uploaded_asset($this->cr_file_id),
            "vat_file" => uploaded_asset($this->vat_file_id),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
