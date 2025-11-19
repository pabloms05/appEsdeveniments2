<?php

namespace Database\Seeders;

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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'birth_date' => '1990-01-01',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pep',
            'email' => 'pep@gmail.com',
            'password' => bcrypt('user123'),
            'birth_date' => '2004-05-10',
            'role' => 'user',
        ]);
    }

}
