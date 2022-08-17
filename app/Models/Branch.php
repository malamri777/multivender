<?php

namespace App\Models;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const STATUS_RADIO = [
        'published' => 'Published',
        'draft'     => 'Draft',
        'block'     => 'Block',
    ];

    public $table = 'branches';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'status',
        'restaurant_id',
        'country_id',
        'state_id',
        'city_id',
        'lang',
        'lat',
        'district_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
//        Branch::observe(new \App\Observers\BranchActionObserver());
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function branchOrders()
    {
        return $this->hasMany(Order::class, 'branch_id', 'id');
    }

    public function branchProducts()
    {
        return $this->hasMany(BranchProduct::class, 'branch_id', 'id');
    }

    public function branchUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function branchDrivers()
    {
        return $this->belongsToMany(BranchDriver::class);
    }

    public function Restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
