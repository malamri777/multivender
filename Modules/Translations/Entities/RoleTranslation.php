<?php

namespace Modules\Translations\Entities;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'role_id'];

    public function role(){
        return $this->belongsTo(Role::class);
    }


    protected static function newFactory()
    {
        return \Modules\Translations\Database\factories\RoleTranslationFactory::new();
    }
}
