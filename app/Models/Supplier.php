<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Sluggable;

    public const STATUS_RADIO = [
        'published' => 'Published',
        'draft'     => 'Draft',
        'block'     => 'Block',
    ];

    public $table = 'suppliers';

    // protected $appends = [
    //     'logo',
    // ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'contact_user',
        'description',
        'content',
        'status',
        'admin_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot()
    {

        parent::boot();

        static::created(function ($model) {

            $parentUpload = Upload::firstOrCreate([
                'folder_name_slug' => $model->slug
            ],[
                'folder_name' => $model->slug,
                'order' => 0,
                'folder_id' => 1,
                'type' => 'folder',
                'role_type' => Upload::ROLE_TYPE['supplier']
            ]);

            $model->parent_folder_id = $parentUpload->id;
            $model->save();
        });

        // static::created(function ($model) {

        // });
    }

    public function admin()
    {
        return $this->hasOne(User::class,'provider_id');
    }

    public function supplierWarehouses()
    {
        return $this->hasMany(Warehouse::class, 'supplier_id', 'id');
    }

    public function warehouseProudct()
    {
        return $this->hasManyThrough(WarehouseProduct::class, Warehouse::class);
    }

    public function parentFolder() {
        return $this->belongsTo(Upload::class, 'parent_folder_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
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
