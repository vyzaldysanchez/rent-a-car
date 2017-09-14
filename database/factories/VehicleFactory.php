<?php

use App\Models\{
    Fuel, Vehicle, VehicleBrand, VehicleModel, VehicleType
};
use Faker\Generator as Faker;

$factory->define(Vehicle::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\StringProvider($faker));

    return [
        'description' => $faker->text(40),
        'chassis_number' => $faker->randomString(Vehicle::CHASSIS_LENGTH),
        'engine_number' => $faker->randomString(Vehicle::ENGINE_LENGTH),
        'plate_number' => $faker->randomString(Vehicle::PLATE_LENGTH),
        'vehicle_type_id' => function () {
            return factory(VehicleType::class)->create()->id;
        },
        'vehicle_brand_id' => function () {
            return factory(VehicleBrand::class)->create()->id;
        },
        'vehicle_model_id' => function (array $post) {
            return factory(VehicleModel::class)->create(['vehicle_brand_id' => $post['vehicle_brand_id']])->id;
        },
        'fuel_id' => function () {
            return factory(Fuel::class)->create()->id;
        },
    ];
});
