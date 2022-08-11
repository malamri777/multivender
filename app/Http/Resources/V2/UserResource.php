<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'uuid' => (int) $this->uuid,
            'name' => $this->name,
            'type' => $this->user_type,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'avatar_original' => uploaded_asset($this->avatar_original),
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'country_dial_code' => $this->country_dial_code,
            'country_code' => $this->country_code,
        ];
    }
}
