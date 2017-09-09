<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(\App\Models\VehicleModel::class, function (Faker $faker) {
    $currentDate = Carbon::now();

    return [
        'description' => $faker->text(50),
        'created_at' => $currentDate,
        'updated_at' => $currentDate
    ];
});