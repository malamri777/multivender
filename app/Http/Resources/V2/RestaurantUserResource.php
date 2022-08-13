<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantUserResource extends JsonResource
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
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'avatar_original' => uploaded_asset($this->logo),
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'country_dial_code' => $this->country_dial_code,
            'country_code' => $this->country_code,
            'device_token' => $this->device_token,
            'device_model' => $this->device_model,
            'device_uuid' => $this->device_uuid,
            'device_manufacturer' => $this->device_manufacturer,
            'device_version' => $this->device_version,
            'device_platform' => $this->device_platform,
            'restaurant' => RestaurantResource::make($this->restaurant),
            'roles' => $this->roles->pluck('name'),
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
