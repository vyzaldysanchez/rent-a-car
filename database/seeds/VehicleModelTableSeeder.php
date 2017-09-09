<?php

use Illuminate\Database\Seeder;

class VehicleModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\VehicleModel::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $brand = \App\VehicleBrand::all('id')->first();

        factory(\App\VehicleModel::class, 10)
            ->create(['vehicle_brand_id' => $brand->id]);
    }
}
