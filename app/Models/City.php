<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use Modules\Translations\Entities\CityTranslation;

class City extends Model
{
    protected $with = ['city_translation'];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? getLocalMapper() : $lang;
        $city_translation = $this->city_translation->where('lang', $lang)->first();
        return $city_translation != null ? $city_translation->$field : $this->$field;
    }

    public function city_translation(){
       return $this->hasMany(CityTranslation::class);
    }

    public function country_translations()
    {
        return $this->hasMany(CountryTranslation::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
