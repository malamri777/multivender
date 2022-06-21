<?php

namespace Modules\Translations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = ['lang', 'lang_key', 'lang_value'];

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\TranslationFactory::new();
    }
}
