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

    protected $fillable = [
        'name',
        'identification_card',
        'work_schedule',
        'commission_percent',
        'admission_date',
        'state'
    ];
}
