<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Fuel
 * @package App
 *
 * @property int $id
 * @property string $description
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 */
class Fuel extends Model
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
    protected $state;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    protected $fillable = ['description', 'state'];
}
