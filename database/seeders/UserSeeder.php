<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'type' =>'user',
            'name' => 'Mac Wolf',
            'email' => 'lucianmacwolf@gmail.com',
            'password' => bcrypt('123456')
        ]);

        Admin::create([
            'type' =>'admin',
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
    }
}
