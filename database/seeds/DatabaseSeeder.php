<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VehicleTypesTableSeeder::class);
        $this->call(VehicleBrandTableSeeder::class);
        $this->call(VehicleModelTableSeeder::class);
        $this->call(FuelTableSeeder::class);
    }
}
