<?php

namespace Modules\Translations\Entities;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\CategoryTranslationFactory::new();
    }
}
