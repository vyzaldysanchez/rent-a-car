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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Fuel::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        factory(Fuel::class, 10)->create();
    }
}
