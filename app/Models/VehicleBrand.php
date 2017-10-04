<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @package App
 * Class VehicleBrand
 * @property int $id
 * @property string $description
 * @property string $state
 * @property string $image_url
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
    /**
     * @var string
     */
    protected $image_url;

    protected $fillable = ['description', 'image_url', 'state'];

    protected $hidden = ['created_at', 'updated_at'];
}
