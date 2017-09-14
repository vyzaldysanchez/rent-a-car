<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(\App\Models\VehicleModel::class, function (Faker $faker) {
    $currentDate = Carbon::now();

    return [
        'description' => $faker->text(50),
        'vehicle_brand_id' => function () {
            return factory(\App\Models\VehicleBrand::class)->create()->id;
        },
        'created_at' => $currentDate,
        'updated_at' => $currentDate
    ];
});