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

        factory(\App\VehicleType::class, 10)->create();
    }
}
