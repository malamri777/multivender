<?php

namespace Modules\Translations\Entities;

use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DistrictTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'district_id'];

    public function district(){
        return $this->belongsTo(District::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\DistrictTranslationFactory::new();
    }
}
