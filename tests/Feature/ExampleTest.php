<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Prototipamos');
    }

    public function test_admin_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk();
    }

    public function test_authenticated_editor_can_open_admin_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertOk()->assertSee('Panel editorial');
        $this->actingAs($user)->get('/admin/publicaciones')->assertOk()->assertSee('Publicaciones');
        $this->actingAs($user)->get('/admin/publicaciones/nueva')->assertOk()->assertSee('Nueva publicación');
        $this->actingAs($user)->get('/admin/consultas')->assertOk()->assertSee('Consultas');
    }
}
