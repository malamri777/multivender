<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const STATUS_RADIO = [
        'published' => 'Published',
        'draft'     => 'Draft',
        'block'     => 'Block',
    ];

    public $table = 'suppliers';

    protected $appends = [
        'logo',
    ];

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
//        Supplier::observe(new \App\Observers\SupplierActionObserver());
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')->fit('crop', 50, 50);
    //     $this->addMediaConversion('preview')->fit('crop', 120, 120);
    // }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function supplierWarehouses()
    {
        return $this->hasMany(Warehouse::class, 'supplier_id', 'id');
    }

//    public function getLogoAttribute()
//    {
//        return $this->getMedia('logo')->last();
//    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
