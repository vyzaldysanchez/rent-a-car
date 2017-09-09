<?php

use Illuminate\Database\Seeder;

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\VehicleBrand::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(\App\VehicleBrand::class, 10)->create();
    }
}
