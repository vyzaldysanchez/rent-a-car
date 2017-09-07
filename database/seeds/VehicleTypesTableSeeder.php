<?php

use Illuminate\Database\Seeder;

class VehicleTypesTableSeeder extends Seeder
{
    private const MAX_TYPES_TO_CREATE = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\VehicleType::truncate();

        $faker = \Faker\Factory::create();

        $vehicleTypesCreated = 0;
        for (; $vehicleTypesCreated < static::MAX_TYPES_TO_CREATE; $vehicleTypesCreated++) {
            \App\VehicleType::create([
                'description' => $faker->text(50),
                'image_path' => $faker->imageUrl(),
                'state' => 'ACTIVE'
            ]);
        }
    }
}
