<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App;
use Modules\Translations\Entities\CategoryTranslation;

class Category extends Model
{
    use Sluggable;

    protected $with = ['category_translations'];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? getLocalMapper() : $lang;
        $category_translation = $this->category_translations->where('lang', $lang)->first();
        return $category_translation != null ? $category_translation->$field : $this->$field;
    }

    public function category_translations(){
    	return $this->hasMany(CategoryTranslation::class);
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }

    public function popularProducts()
    {
        return $this->hasMany(Product::class)->orderBy('num_of_sale', 'desc')->limit(10);
    }

    public function classified_products(){
    	return $this->hasMany(CustomerProduct::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
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
