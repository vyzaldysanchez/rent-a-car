<?php

use App\Models\PersonType;
use Illuminate\Database\Seeder;

class PersonTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PersonType::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(PersonType::class, 1)->create(['name' => PersonType::LEGAL_TYPE]);
        factory(PersonType::class, 1)->create(['name' => PersonType::PHYSICAL_TYPE]);
    }
}
