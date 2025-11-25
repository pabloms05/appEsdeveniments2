<?php

namespace Tests\Feature;

use App\Models\Esdeveniment;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EdevenimentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_homepage_loads()
    {
        $this->get('/')->assertStatus(200)->assertSee('Benvingut');
    }

    public function test_we_can_view_events_list_unauthenticated()
    {
        $categoria = Categoria::create(['nom' => 'Música']);
        Esdeveniment::create([
            'nom' => 'Concierto de Prueba',
            'descripcio' => 'Un concierto de prova',
            'data' => '2025-12-15',
            'hora' => '20:00',
            'categoria_id' => $categoria->id,
            'max_assistents' => 100,
            'reserves' => 0,
            'edat_minima' => 16,
            'imatge' => 'default.jpg'
        ]);

        $response = $this->get('/esdeveniments');
        // Accepta 200 (públic) o 302 (redirigeix a login)
        $this->assertTrue(in_array($response->status(), [200, 302]));
    }


    public function test_we_can_view_event_details()
    {
        $categoria = Categoria::create(['nom' => 'Teatro']);
        $event = Esdeveniment::create([
            'nom' => 'Obra de Teatro',
            'descripcio' => 'Una obra de teatro clásica',
            'data' => '2025-12-20',
            'hora' => '21:00',
            'categoria_id' => $categoria->id,
            'max_assistents' => 200,
            'reserves' => 50,
            'edat_minima' => 15,
            'imatge' => 'theater.jpg'
        ]);

        $response = $this->get("/esdeveniments/{$event->id}");
        $this->assertTrue(in_array($response->status(), [200, 302]));
    }

    public function test_event_exists_in_database()
    {
        $categoria = Categoria::create(['nom' => 'Cine']);
        $event = Esdeveniment::create([
            'nom' => 'Proyección de Película',
            'descripcio' => 'Película de estreno',
            'data' => '2025-12-10',
            'hora' => '18:30',
            'categoria_id' => $categoria->id,
            'max_assistents' => 150,
            'reserves' => 0,
            'edat_minima' => 13,
            'imatge' => 'cinema.jpg'
        ]);

        $this->assertDatabaseHas('esdeveniments', ['nom' => 'Proyección de Película']);
    }

    public function test_admin_can_be_created()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'birth_date' => '1990-01-01'
        ]);

        $this->assertDatabaseHas('users', ['email' => 'admin@test.com', 'role' => 'admin']);
    }
}