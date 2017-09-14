<?php

use App\Models\{
    VehicleBrand, VehicleModel
};
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
        VehicleModel::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(VehicleModel::class, 10)->create();
    }
}
