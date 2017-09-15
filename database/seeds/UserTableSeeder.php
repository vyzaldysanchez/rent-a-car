<?php

use App\Models\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(User::class, 1)->create([
            'email' => 'admin@rent-a-car.net',
            'role' => UserRole::ADMIN
        ]);
    }
}
