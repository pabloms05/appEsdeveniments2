<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create(['nom' => 'Concerts']);
        Categoria::create(['nom' => 'Tallers']);
        Categoria::create(['nom' => 'Esports']);
        Categoria::create(['nom' => 'Teatre']);
    }
}
