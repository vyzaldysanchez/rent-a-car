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
 */
class Fuel extends Model
{
    protected $id;
    protected $description;
    protected $state;

    protected $fillable = ['description', 'state'];
}
