<?php

namespace Modules\Translations\Entities;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'unit', 'description', 'lang'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\ProductTranslationFactory::new();
    }
}
