<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleType
 * @package App
 * @property int $id
 * @property string $description
 * @property string $image_url
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 */
class VehicleType extends Model
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $image_url;
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

    protected $fillable = ['description', 'image_url', 'state'];

    protected $hidden = ['created_at', 'updated_at'];
}
