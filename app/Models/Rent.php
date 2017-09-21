<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rent
 * @package App\Models
 *
 * @property int    $id
 * @property string $created_at
 * @property string $updated_at
 */
class Rent extends Model
{
    protected $id;
    protected $return_date;
    protected $expected_return_date;
    protected $daily_fee;
    protected $duration_in_days;
    protected $comment;
    protected $employee_id;
    protected $client_id;
    protected $vehicle_id;

    protected $fillable = [
        'rent_date',
        'expected_return_date',
        'return_date',
        'daily_fee',
        'duration_in_days',
        'comment',
        'state',
        'employee_id',
        'vehicle_id',
        'client_id',
    ];
}
