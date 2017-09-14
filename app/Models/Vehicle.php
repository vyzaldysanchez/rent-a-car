<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle
 * @package App\Models
 *
 * @property int $id
 * @property string $description
 * @property string $chassis_number
 * @property string $engine_number
 * @property string $plate_number
 * @property int $vehicle_type_id
 * @property int $vehicle_brand_id
 * @property int $vehicle_model_id
 * @property int $fuel_id
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 */
class Vehicle extends Model
{
    const CHASSIS_LENGTH = 17;
    const ENGINE_LENGTH = 11;
    const PLATE_LENGTH = 8;

    protected $fillable = [
        'description',
        'chassis_number',
        'engine_number',
        'plate_number',
        'vehicle_type_id',
        'vehicle_brand_id',
        'vehicle_model_id',
        'fuel_id',
        'state'
    ];

    public function type(): VehicleType
    {
        return $this->hasOne('App\Models\VehicleType');
    }

    public function brand(): VehicleBrand
    {
        return $this->hasOne('App\Models\VehicleBrand');
    }

    public function model(): VehicleModel
    {
        return $this->hasOne('App\Models\VehicleModel');
    }

    public function fuel(): Fuel
    {
        return $this->hasOne('App\Models\Fuel');
    }
}
