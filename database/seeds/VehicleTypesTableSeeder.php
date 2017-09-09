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
        VehicleType::truncate();

        factory(VehicleType::class, 10)->create();
    }
}
