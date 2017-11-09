<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class Employee
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property string $identification_card
 * @property string $work_schedule
 * @property float  $commission_percent
 * @property string $admission_date
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property int    $user_id
 * @property User   $user
 */
class Employee extends User
{
    protected $id;
    protected $name;
    protected $identification_card;
    protected $work_schedule;
    protected $commission_percent;
    protected $admission_date;
    protected $state;
    protected $created_at;
    protected $updated_at;
    protected $user_id;

    protected $fillable = [
        'name',
        'identification_card',
        'work_schedule',
        'commission_percent',
        'admission_date',
        'state',
        'user_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function (Employee $employee) {
            $employee->user()->delete();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    public static function existsByIdentificationCard(string $identification): boolean
    {
        return parent::where('identification_card', '=', $identification)->exists();
    }
}
