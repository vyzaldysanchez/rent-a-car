<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Enums\VehicleState;

/**
 * Class Vehicle
 * @package App\Models
 *
 * @property int          $id
 * @property string       $description
 * @property string       $chassis_number
 * @property string       $engine_number
 * @property string       $plate_number
 * @property int          $vehicle_type_id
 * @property int          $vehicle_brand_id
 * @property int          $vehicle_model_id
 * @property int          $fuel_id
 * @property string       $state
 * @property VehicleType  $type
 * @property VehicleBrand $brand
 * @property VehicleModel $model
 * @property Fuel         $fuel
 * @property string       $created_at
 * @property string       $updated_at
 */
class Vehicle extends Model
{
    const CHASSIS_LENGTH = 17;
    const ENGINE_LENGTH = 11;
    const PLATE_LENGTH = 8;
    const RELATIONS = ['type', 'brand', 'model', 'fuel'];

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

    protected $hidden = [
        'vehicle_type_id',
        'vehicle_brand_id',
        'vehicle_model_id',
        'fuel_id',
        'created_at',
        'updated_at'
    ];

    protected $with = self::RELATIONS;

    public function type() : BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function brand() : BelongsTo
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }

    public function model() : BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function fuel() : BelongsTo
    {
        return $this->belongsTo(Fuel::class, 'fuel_id');
    }

    public static function getWithRelations($columns = ['*']) : Collection
    {
        return static::getWithRelationsQuery()->get($columns);
    }

    public static function getAllAvailableWithRelations($columns = ['*']) : Collection
    {
        return static::getWithRelationsQuery()
            ->where('state', VehicleState::AVAILABLE)
            ->get($columns);
    }

    public static function getWithRelationsQuery() : Builder
    {
        return parent::with(static::RELATIONS);
    }
}