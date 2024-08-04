<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Usuario',
            'email' => 'usuario@notarychain.com',
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Usuario2',
            'email' => 'usuario2@notarychain.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
