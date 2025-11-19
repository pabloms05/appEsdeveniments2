<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Esdeveniment;
use App\Models\Categoria;
use Faker\Factory as Faker;

class EsdevenimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categorias = Categoria::all();

        // Crear 4 esdeveniments
        Esdeveniment::create([
            'nom' => 'Festa Electrònica 2025',
            'descripcio' => 'Vine a gaudir d\'una nit inoblidable amb música en viu, DJ internacionals i una festa èpica.',
            'data' => '2025-05-20',
            'hora' => '22:00',
            'max_assistents' => 800,
            'reserves' => 500,
            'edat_minima' => 18,
            'imatge' => 'festaElectronica2025.jpg',
            'categoria_id' => 1,
        ]);

        Esdeveniment::create([
            'nom' => 'Nit Rumbera 2025',
            'descripcio' => 'La millor rumba llatina de la ciutat, amb orquestres en viu i begudes especials.',
            'data' => '2025-06-15',
            'hora' => '23:00',
            'max_assistents' => 600,
            'reserves' => 320,
            'edat_minima' => 18,
            'imatge' => 'nitRumbera.jpg',
            'categoria_id' => 1,
        ]);

        Esdeveniment::create([
            'nom' => 'Taller de ceràmica',
            'descripcio' => 'Aprèn a fer peces de ceràmica artesana.',
            'data' => '2025-06-20',
            'hora' => '17:00',
            'max_assistents' => 20,
            'reserves' => 9,
            'edat_minima' => 14,
            'imatge' => 'tallerCeramica.jpg',
            'categoria_id' => 2,
        ]);

        Esdeveniment::create([
            'nom' => 'Introducció al dibuix',
            'descripcio' => 'Sessió de dibuix per a principiants.',
            'data' => '2025-06-25',
            'hora' => '10:00',
            'max_assistents' => 25,
            'reserves' => 11,
            'edat_minima' => 10,
            'imatge' => 'tallerDibuix.jpg',
            'categoria_id' => 2,
        ]);

        Esdeveniment::create([
            'nom' => 'Torneig de futbol',
            'descripcio' => 'Competició amateur entre equips locals.',
            'data' => '2025-07-05',
            'hora' => '09:00',
            'max_assistents' => 200,
            'reserves' => 189,
            'edat_minima' => 18,
            'imatge' => 'torneigFutbol.jpg',
            'categoria_id' => 3,
        ]);

        Esdeveniment::create([
            'nom' => 'Cursa Popular 2025',
            'descripcio' => 'Cursa de 10 km per a tots els nivells.',
            'data' => '2025-07-08',
            'hora' => '08:00',
            'max_assistents' => 500,
            'reserves' => 350,
            'edat_minima' => 16,
            'imatge' => 'cursaPopular.jpg',
            'categoria_id' => 3,
        ]);

        Esdeveniment::create([
            'nom' => 'Teatre Clàssic',
            'descripcio' => 'Representació d\'una obra de teatre clàssic.',
            'data' => '2025-07-10',
            'hora' => '20:00',
            'max_assistents' => 150,
            'reserves' => 90,
            'edat_minima' => 12,
            'imatge' => 'teatreClassic.jpg',
            'categoria_id' => 4,
        ]);

        Esdeveniment::create([
            'nom' => 'Teatre Modern',
            'descripcio' => 'Representació d\'una obra de teatre modern.',
            'data' => '2025-07-15',
            'hora' => '19:00',
            'max_assistents' => 200,
            'reserves' => 110,
            'edat_minima' => 12,
            'imatge' => 'teatreModern.jpg',
            'categoria_id' => 4,
        ]);
    }
}
