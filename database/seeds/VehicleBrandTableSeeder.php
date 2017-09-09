<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VehicleBrandTableSeeder extends Seeder
{
    private const MAX_TYPES_TO_CREATE = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\VehicleBrand::truncate();

        $faker = \Faker\Factory::create();

        $brandsCreated = 0;

        for (; $brandsCreated < static::MAX_TYPES_TO_CREATE; $brandsCreated++) {
            $currentDate = Carbon::now();
            \App\VehicleBrand::create([
                'description'=> $faker->text(50),
                'image_url' => $faker->imageUrl(),
                'created_at' => $currentDate,
                'updated_at' => $currentDate,
            ]);
        }
    }
}
