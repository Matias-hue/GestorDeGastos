<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que la raíz redirige al login si no hay sesión.
     */
    public function test_the_application_redirects_to_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Verifica que un usuario autenticado puede acceder a la ruta /principal.
     */
    public function test_authenticated_user_can_access_principal(): void
    {
        $user = User::factory()->create();

        // Simulamos que el usuario inicia sesión
        $response = $this->actingAs($user)->get('/principal');

        $response->assertStatus(200);
    }
}
