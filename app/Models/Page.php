<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App;
use Modules\Translations\Entities\PageTranslation;

class Page extends Model
{
    use Sluggable;

    protected $fillable = ['type', 'title', 'content', 'meta_title', 'meta_description', 'keywords',];
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $page_translation = $this->hasMany(PageTranslation::class)->where('lang', $lang)->first();
        return $page_translation != null ? $page_translation->$field : $this->$field;
    }

    public function page_translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
