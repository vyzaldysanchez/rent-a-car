<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleModel
 * @package App
 * @property int                      $id
 * @property int                      $vehicle_brand_id
 * @property string                   $description
 * @property string                   $state
 * @property string                   $created_at
 * @property string                   $updated_at
 * @property \App\Models\VehicleBrand $brand
 */
class VehicleModel extends Model
{
    use HasRelationShips, QueriesRelationships;

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $vehicle_brand_id;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $state;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    protected $fillable = ['vehicle_brand_id', 'description', 'state'];

    protected $hidden = ['created_at', 'updated_at'];

    public function brand()
    {
        return $this->belongsTo('\App\Models\VehicleBrand', 'vehicle_brand_id');
    }
}
