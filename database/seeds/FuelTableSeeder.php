<?php

use Illuminate\Database\Seeder;
use App\Models\Fuel;

class FuelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fuel::truncate();
        factory(Fuel::class, 10)->create();
    }
}
