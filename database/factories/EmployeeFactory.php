<?php
use Faker\Generator as Faker;
use App\Models\Employee;
use App\Models\Enums\EmployeeWorkSchedule;
use Carbon\Carbon;

$factory->define(Employee::class, function (Faker $faker) {
    $currentDate = Carbon::now();

    return [
        'name' => $faker->name('M'),
        'work_schedule' => EmployeeWorkSchedule::NIGHT,
        'commission_percent' => $faker->randomFloat(2, 3, 99.99),
        'admission_date' => $currentDate,
        'created_at' => $currentDate,
        'updated_at' => $currentDate
    ];
});
