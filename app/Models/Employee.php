<?php

namespace App\Models;

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
 * @property int $user_id
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
}
