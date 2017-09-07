<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @package App
 * Class VehicleBrand
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 */
class VehicleBrand extends Model
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $state;

    protected $fillable = ['description', 'imageUrl'];
}
