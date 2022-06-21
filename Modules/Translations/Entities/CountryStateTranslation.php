<?php

namespace Modules\Translations\Entities;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CountryStateTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'state_id'];

    public function country(){
        return $this->belongsTo(State::class);
    }

    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\CountryStateTranslationFactory::new();
    }
}
