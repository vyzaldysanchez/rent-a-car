<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle
 * @package App\Models
 *
 * @property int $id
 * @property int $description
 * @property int $chassis_number
 * @property int $engine_number
 * @property int $plate_number
 * @property int $vehicle_type_id
 * @property int $vehicle_brand_id
 * @property int $vehicle_model_id
 * @property int $fuel_id
 * @property int $state
 * @property int $created_at
 * @property int $updated_at
 */
class Vehicle extends Model
{
    const CHASSIS_LENGTH = 17;
    const ENGINE_LENGTH = 11;
    const PLATE_LENGTH = 8;

    public function type(): VehicleType
    {
        return $this->belongsTo('App\Models\VehicleType');
    }

    public function brand(): VehicleBrand
    {
        return $this->belongsTo('App\Models\VehicleBrand');
    }

    public function model(): VehicleModel
    {
        return $this->belongsTo('App\Models\VehicleModel');
    }

    public function fuel(): Fuel
    {
        return $this->belongsTo('App\Models\Fuel');
    }
}
