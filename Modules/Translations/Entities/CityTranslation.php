<?php

namespace Modules\Translations\Entities;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CityTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'city_id'];

    public function city(){
        return $this->belongsTo(City::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\CityTranslationFactory::new();
    }
}
