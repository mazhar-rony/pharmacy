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
            'name' => 'Super Admin',
            'email' => 'mazhar.rony@gmail.com',
            'is_super_admin' => '1',
            'password' => Hash::make('superadmin')
        ]);

        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => Hash::make('password')
        ]);

    }
}
