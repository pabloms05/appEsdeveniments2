<?php

namespace Tests\Feature;

use App\Models\Esdeveniment;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EdevenimentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_homepage_loads()
    {
        $this->get('/')->assertStatus(200)->assertSee('Eventos');
    }

    public function test_we_can_view_events_list()
    {
        $categoria = Categoria::create(['nom' => 'Música']);
        Esdeveniment::create([
            'nom' => 'Concierto de Prueba',
            'descripcio' => 'Un concierto de prueba',
            'data' => '2025-12-15',
            'hora' => '20:00',
            'categoria_id' => $categoria->id,
            'max_assistents' => 100,
            'reserves' => 0,
            'edat_minima' => 16,
            'imatge' => 'default.jpg'
        ]);

        $response = $this->get('/evenimente');
        $response->assertStatus(200)->assertSee('Concierto de Prueba');
    }

    public function test_we_can_create_an_event_as_admin()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $categoria = Categoria::create(['nom' => 'Deportes']);

        $response = $this->actingAs($admin)->post('/evenimente', [
            'nom' => 'Partido de Fútbol',
            'descripcio' => 'Un partido amistoso',
            'data' => '2025-11-25',
            'hora' => '19:00',
            'categoria_id' => $categoria->id,
            'max_assistents' => 500,
            'edat_minima' => 12,
            'imatge' => 'football.jpg'
        ]);

        $response->assertRedirect('/eventi');
        $this->assertDatabaseHas('esdeveniments', ['nom' => 'Partido de Fútbol']);
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
            'edat_minima' => 14,
            'imatge' => 'theater.jpg'
        ]);

        $response = $this->get("/collegamenti/{$event->id}");
        $response->assertStatus(200)->assertSee('Obra de Teatro');
    }

    public function test_we_can_reserve_an_event()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

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

        $response = $this->actingAs($user)->post("/collegamenti/{$event->id}/reserva");
        $response->assertRedirect();
        $this->assertDatabaseHas('reserves', ['user_id' => $user->id, 'esdeveniment_id' => $event->id]);
    }

    public function test_we_cannot_reserve_event_without_tickets()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $categoria = Categoria::create(['nom' => 'Concierto']);
        $event = Esdeveniment::create([
            'nom' => 'Concierto Lleno',
            'descripcio' => 'Concierto sin entradas',
            'data' => '2025-12-05',
            'hora' => '20:00',
            'categoria_id' => $categoria->id,
            'max_assistents' => 100,
            'reserves' => 100,
            'edat_minima' => 18,
            'imatge' => 'concert.jpg'
        ]);

        $response = $this->actingAs($user)->post("/collegamenti/{$event->id}/reserva");
        $response->assertStatus(403); // O el status que retornis quan no hi ha entrades
    }

    public function test_admin_can_delete_event()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $categoria = Categoria::create(['nom' => 'Deportes']);
        $event = Esdeveniment::create([
            'nom' => 'Evento a Eliminar',
            'descripcio' => 'Será eliminado',
            'data' => '2025-12-30',
            'hora' => '16:00',
            'categoria_id' => $categoria->id,
            'max_assistents' => 50,
            'reserves' => 0,
            'edat_minima' => 10,
            'imatge' => 'delete.jpg'
        ]);

        $response = $this->actingAs($admin)->delete("/Події/{$event->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('esdeveniments', ['id' => $event->id]);
    }
}