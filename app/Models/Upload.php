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
        'folder_name', 'folder_id', 'file_original_name', 'file_name', 'user_id', 'extension', 'type', 'file_size',
    ];

    public static function boot() {
        parent::boot();

        static::creating(function (Upload $upload) {
            if ($upload->type === "folder") {
                $upload->order = 0;
            } else {
                $upload->order = 1;
            }
        });
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function parent() {
        return $this->belongsTo(Upload::class, 'folder_id', 'id');
    }

    public function children() {
        return $this->hasMany(Upload::class, 'folder_id');
    }
}
