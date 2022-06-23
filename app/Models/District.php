<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Modules\Translations\Entities\DistrictTranslation;

class District extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'districts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'city_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $district_translation = $this->hasMany(DistrictTranslation::class)->where('lang', $lang)->first();
        return $district_translation != null ? $district_translation->$field : $this->$field;
    }

    public function districtWarehouses()
    {
        return $this->hasMany(Warehouse::class, 'district_id', 'id');
    }

    public function districtBranches()
    {
        return $this->hasMany(Branch::class, 'district_id', 'id');
    }

    public function workingDistrictWarehouseDrivers()
    {
        return $this->hasMany(WarehouseDriver::class, 'working_district_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function warehouseDrivers()
    {
        return $this->hasManyThrough(Warehouse::class, User::class);
    }

//    public function driver()
//    {
//        return $this->hasManyThrough(
//            User::class,
//            Environment::class,
//            'project_id', // Foreign key on the environments table...
//            'environment_id', // Foreign key on the deployments table...
//            'id', // Local key on the projects table...
//            'id' // Local key on the environments table...
//        );
//    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
