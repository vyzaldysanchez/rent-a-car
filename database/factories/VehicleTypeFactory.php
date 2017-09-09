<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(\App\VehicleType::class, function (Faker $faker) {
    $currentDate = Carbon::now();

    return [
        'description' => $faker->text(50),
        'image_url' => $faker->imageUrl(),
        'created_at' => $currentDate,
        'updated_at' => $currentDate
    ];
});
