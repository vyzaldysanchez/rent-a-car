<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inspection
 * @package App
 *
 * @property int    $id
 * @property string $created_at
 * @property string $updated_at
 */
class Inspection extends Model
{
    protected $id;
    protected $has_scratches;
    protected $has_spare_tire;
    protected $has_jack;
    protected $has_broken_glasses;
    protected $fuel_qty;
    protected $date;
    protected $top_left_tire_state;
    protected $top_right_tire_state;
    protected $bottom_left_tire_state;
    protected $bottom_right_tire_state;
    protected $created_at;
    protected $updated_at;

    protected $fillable = [
        'has_scratches',
        'has_spare_tire',
        'has_jack',
        'has_broken_glasses',
        'fuel_qty',
        'date',
        'top_left_tire_state',
        'top_right_tire_state',
        'bottom_left_tire_state',
        'bottom_right_tire_state'
    ];
}
