<?php

namespace App\Http\Resources\V2;

use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->getTranslation('name'),
            'photos' => explode(',', uploaded_asset($this->photos)),
            'thumbnail_image' => uploaded_asset($this->thumbnail_img),
            'base_price' => (float) home_base_price($this, false),
            'base_discounted_price' => (float) home_discounted_base_price($this, false),
            'todays_deal' => (int) $this->todays_deal,
            'featured' => (int) $this->featured,
            'unit' => $this->unit,
            'discount' => (float) $this->discount,
            'discount_type' => $this->discount_type,
            'rating' => (float) $this->rating,
            'sales' => (int) $this->num_of_sale,
        ];
    }
}
