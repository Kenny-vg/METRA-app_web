<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cafeteria;
use App\Models\User;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_cafeterias_publicas_endpoint()
    {
        $response = $this->get('/api/cafeterias-publicas');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
        $response->assertJson(['success' => true]);
    }

    public function test_cafeteria_detalles_using_slug()
    {
        // Require a user for the foreign key
        $user = User::factory()->create();

        $cafeteria = Cafeteria::create([
            'nombre' => 'Test Cafe',
            'slug' => 'test-cafe',
            'estado' => 'activa',
            'user_id' => $user->id
        ]);

        $response = $this->get('/api/cafeterias-publicas/' . $cafeteria->slug);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $cafeteria->id,
                'slug' => 'test-cafe',
                'nombre' => 'Test Cafe'
            ]
        ]);
    }

    public function test_cafeteria_menu_endpoint_using_slug()
    {
        $user = User::factory()->create();

        $cafeteria = Cafeteria::create([
            'nombre' => 'Test Cafe',
            'slug' => 'test-cafe',
            'estado' => 'activa',
            'user_id' => $user->id
        ]);

        $response = $this->get('/api/cafeterias/' . $cafeteria->slug . '/menu');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
}
