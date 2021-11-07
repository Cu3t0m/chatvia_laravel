<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'phone' => '123-123-1234',
            'name' => 'Admin',
            'email' => 'admin@themesbrand.com',
            'password' => Hash::make('password'), 
            'avatar' => '/assets/images/users/avatar-1.jpg',
            'location' => '831 Bradford Well West Lenny, VT 69684-2809',
            'created_at' => now(),
        ]);

        DB::table('users')->insert([
            'phone' => '123-456-1234',
            'name' => 'User',
            'email' => 'user@themesbrand.com',
            'password' => Hash::make('password'), 
            'avatar' => '/assets/images/users/avatar-2.jpg',
            'location' => '735 Lebsack Pines Apt. 857 Princechester, MT 58698-4590',
            'created_at' => now(),
        ]);
    }
}
