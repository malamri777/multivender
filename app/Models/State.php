<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Translations\Entities\CountryStateTranslation;

class State extends Model
{
    use HasFactory;

    protected $with = ['state_translations'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? getLocalMapper() : $lang;
        $state_translations = $this->state_translations->where('lang', $lang)->first();
        return $state_translations != null ? $state_translations->$field : $this->$field;
    }

    public function state_translations()
    {
        return $this->hasMany(CountryStateTranslation::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function cities(){
        return $this->hasMany(City::class);
    }
}
