<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Laratrust\Models\LaratrustRole;
use Modules\Translations\Entities\RoleTranslation;

class Role extends LaratrustRole
{
    public $guarded = [];

    protected $with = ['role_translations'];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $role_translation = $this->role_translations->where('lang', $lang)->first();
        return $role_translation != null ? $role_translation->$field : $this->$field;
    }

    public function role_translations(){
        return $this->hasMany(RoleTranslation::class);
    }

}
