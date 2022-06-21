<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App;
use Modules\Translations\Entities\BrandTranslation;

class Brand extends Model
{
    use Sluggable;

  protected $with = ['brand_translations'];

  public function getTranslation($field = '', $lang = false){
      $lang = $lang == false ? App::getLocale() : $lang;
      $brand_translation = $this->brand_translations->where('lang', $lang)->first();
      return $brand_translation != null ? $brand_translation->$field : $this->$field;
  }

  public function brand_translations(){
    return $this->hasMany(BrandTranslation::class);
  }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}
