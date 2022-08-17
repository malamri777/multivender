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
            "status" => $this->status ? true : false,
            "restaurant_waiting_for_upload_file" => $this->restaurant_waiting_for_upload_file,
            "restaurant_waiting_for_admin_approve" => $this->restaurant_waiting_for_admin_approve,
            // "admin" => $this->when(Auth::id() != null, Auth::id()),
            "logo" => uploaded_asset($this->logo),
            "cr_file" => uploaded_asset($this->cr_file),
            "vat_file" => uploaded_asset($this->vat_file),
            'branches' => BranchCollection::make($this->restaurantBranches),
            'expiryDate' => json_decode($this->wathqData)->expiryDate ?? null,
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
