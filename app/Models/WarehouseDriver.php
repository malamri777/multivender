<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseDriver extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'warehouse_drivers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'blood_group',
        'vehicle_name',
        'vehicle_color',
        'vehicle_registration_no',
        'vehicle_details',
        'driving_license_no',
        'user_id',
        'nationality_id',
        'working_district_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function warehouseDriverOrders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    public function working_district()
    {
        return $this->belongsTo(District::class, 'working_district_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
