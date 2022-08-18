<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BranchCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'street' => $data->street,
                    'long' => (float) $data->long,
                    'lat' => (float) $data->lat,
                    'state' => $data->state->getTranslation('name'),
                    'city' => $data->city->getTranslation('name'),
                    'district' => $data->district->getTranslation('name'),
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, uploaded_asset($item));
        }
        return $result;
    }
}
