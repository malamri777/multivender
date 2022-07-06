<?php

namespace App\Models;

use App\Models\User;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const STATUS_RADIO = [
        'published' => 'Published',
        'draft'     => 'Draft',
        'block'     => 'Block',
    ];

    public $table = 'warehouses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'status',
        'supplier_id',
        'country_id',
        'city_id',
        'district_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
//        Warehouse::observe(new \App\Observers\WarehouseActionObserver());
    }

    public function warehouseOrders()
    {
        return $this->hasMany(Order::class, 'warehouse_id', 'id');
    }

    public function warehouseWarehouseProducts()
    {
        return $this->hasMany(WarehouseProduct::class, 'warehouse_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function warehouseUsers()
    {
        return $this->belongsToMany(User::class, 'warehouse_users');
    }

    public function warehouseWarehouseDrivers()
    {
        return $this->belongsToMany(WarehouseDriver::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
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
