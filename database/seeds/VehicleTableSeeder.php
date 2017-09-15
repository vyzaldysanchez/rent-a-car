<?php

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::truncate();
        factory(Vehicle::class, 20)->create();
    }
}
