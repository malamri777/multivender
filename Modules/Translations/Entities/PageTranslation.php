<?php

namespace Modules\Translations\Entities;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'title', 'content', 'lang'];

    public function page(){
        return $this->belongsTo(Page::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\PageTranslationFactory::new();
    }
}
