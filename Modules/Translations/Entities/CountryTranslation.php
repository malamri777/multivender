<?php

namespace Modules\Translations\Entities;


use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CountryTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'country_id'];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\CountryTranslationFactory::new();
    }
}
