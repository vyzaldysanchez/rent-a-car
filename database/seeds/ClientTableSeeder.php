<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Client::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        factory(Client::class, 1)->create(['identification_number' => '40223172020']);
        factory(Client::class, 1)->create(['identification_number' => '40245893321']);
    }
}
