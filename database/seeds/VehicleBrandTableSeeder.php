<?php

use App\Models\VehicleBrand;
use Illuminate\Database\Seeder;

class VehicleBrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        VehicleBrand::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(VehicleBrand::class, 10)->create();
    }
}
