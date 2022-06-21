<?php

namespace Modules\Translations\Entities;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'attribute_id'];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\AttributeTranslationFactory::new();
    }
}
