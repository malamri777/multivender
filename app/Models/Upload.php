<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'file_original_name', 'file_name', 'user_id', 'extension', 'type', 'file_size', 'uploadable_id', 'uploadable_type'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function uploadable() {
        return $this->morphTo();
    }
}
