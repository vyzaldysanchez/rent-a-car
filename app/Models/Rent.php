<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Rent
 * @package App\Models
 *
 * @property int    $id
 * @property int    $vehicle_id
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

    protected static function boot() : void
    {
        parent::boot();

        static::saving(function (Rent $rent) {
            $rentDate = Carbon::createFromFormat('Y-m-d', $rent->attributes['rent_date']);
            $returnDate = Carbon::createFromFormat('Y-m-d', $rent->attributes['return_date']);

            $rent->attributes['duration_in_days'] = $rentDate->diffInDays($returnDate);

            return $rent;
        });
    }

    public function vehicle() : BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
