<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Restaurant extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const STATUS_RADIO = [
        'published' => 'Published',
        'draft'     => 'Draft',
        'block'     => 'Block',
    ];

    public $table = 'restaurants';

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
        'cr_no',
        'vat_no',
        'description',
        'content',
        'logo',
        'status',
        'admin_id',
        'cr_file_id',
        'vat_file_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
        // Restaurant::observe(new \App\Observers\RestaurantActionObserver());
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')->fit('crop', 50, 50);
    //     $this->addMediaConversion('preview')->fit('crop', 120, 120);
    // }

    public function admin()
    {
        return $this->belongsTo(User::class,'admin_id');
    }

    public function restaurantBranches()
    {
        return $this->hasMany(Branch::class, 'restaurant_id', 'id');
    }

    // public function userBranches()
    // {
    //     return $this->hasManyThrough(
    //         Branch::class,
    //         WarehouseProduct::class,
    //         'warehouse_id',
    //         'id',
    //         'id',
    //         'product_id'
    //     );
    // }

    public function logoUpload()
    {
        return $this->morphOne(Upload::class, 'uploadable');
    }

    public function logoUploadFilePath()
    {
        return uploaded_asset($this->logoUpload()->first()->id);
    }

    public function crUpload()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('kind', 'cr');
    }

    public function crUploadFilePath()
    {
        return uploaded_asset($this->crUpload()->first()->id);
    }

    public function vatUpload()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('kind', 'vat');
    }

    public function vatUploadFilePath()
    {
        return uploaded_asset($this->vatUpload()->first()->id);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
