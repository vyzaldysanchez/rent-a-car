<?php

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Employee::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $userToSeed = \App\Models\User::first();

        factory(Employee::class, 1)->create([
            'name' => $userToSeed->name,
            'identification_card' => '402-2317202-0',
            'user_id' => $userToSeed->id
        ]);
    }
}
