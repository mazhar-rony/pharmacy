<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'employee_id' => '1',
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'employee_id' => '2',
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password')
        ]);
    }
}
