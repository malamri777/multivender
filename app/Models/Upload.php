<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use SoftDeletes, Sluggable;

    public const ROLE_TYPE = [
        'admin' => 'admin',
        'supplier'     => 'supplier',
        'restaurant'     => 'restaurant',
    ];

    public const KIND = [
        'profile_image' => 'profile_image',
    ];

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

    public function supplierParentFolder()
    {
        return $this->hasOne(Supplier::class, 'parent_folder_id');
    }

    public function scopeRoleType($query, $value = null)
    {
        return $query->where('role_type', $value);
    }

    public function sluggable(): array
    {
        return [
            'folder_name_slug' => [
                'source' => 'folder_name'
            ]
        ];
    }
}
