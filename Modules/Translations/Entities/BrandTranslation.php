<?php

namespace Modules\Translations\Entities;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'brand_id'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\BrandTranslationFactory::new();
    }
}
