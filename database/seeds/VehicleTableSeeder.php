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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Vehicle::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        factory(Vehicle::class, 20)->create();
    }
}
