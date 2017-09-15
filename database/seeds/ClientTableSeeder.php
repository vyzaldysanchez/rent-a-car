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
        Client::truncate();
        factory(Client::class, 1)->create(['identification_number' => '40223172020']);
        factory(Client::class, 1)->create(['identification_number' => '40245893321']);
    }
}
