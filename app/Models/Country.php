<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Translations\Entities\CountryTranslation;

class Country extends Model
{
    protected $with = ['country_translations'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? getLocalMapper() : $lang;
        $country_translations = $this->country_translations->where('lang', $lang)->first();
        return $country_translations != null ? $country_translations->$field : $this->$field;
    }

    public function country_translations()
    {
        return $this->hasMany(CountryTranslation::class);
    }

}
