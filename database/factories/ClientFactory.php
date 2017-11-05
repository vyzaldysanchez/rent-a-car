<?php

use App\Models\Client;
use App\Models\PersonType;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    $currentDate = Carbon::now();

    return [
        'name' => $faker->name('M'),
        'credit_card_number' => $faker->creditCardNumber('Visa'),
        'credit_limit' => $faker->randomFloat(2, 1000, mt_getrandmax()),
        'person_type_id' => function () {
            return PersonType::select('id')->first()->id;
        },
        'created_at' => $currentDate,
        'updated_at' => $currentDate
    ];
});
