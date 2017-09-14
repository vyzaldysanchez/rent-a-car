<?php

use App\Models\PersonType;

$factory->define(PersonType::class, function () {
    $currentDate = \Carbon\Carbon::now();

    return [
        'created_at' => $currentDate,
        'updated_at' => $currentDate
    ];
});
