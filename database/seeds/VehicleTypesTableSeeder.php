<?php

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        VehicleType::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        factory(VehicleType::class, 10)->create();
    }
}
