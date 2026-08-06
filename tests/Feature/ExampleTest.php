<?php

namespace Tests\Feature;

use App\Livewire\Admin\PageEditor;
use App\Models\PageContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
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
        $this->actingAs($user)->get('/admin/sitio')->assertOk()->assertSee('Editar portada');
        $this->actingAs($user)->get('/admin/publicaciones')->assertOk()->assertSee('Publicaciones');
        $this->actingAs($user)->get('/admin/publicaciones/nueva')->assertOk()->assertSee('Nueva publicación');
        $this->actingAs($user)->get('/admin/consultas')->assertOk()->assertSee('Consultas');
    }

    public function test_editor_can_publish_home_text_and_images(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        Livewire::test(PageEditor::class)
            ->set('content.hero.title', "Creamos ideas\nque toman forma.")
            ->set('heroImage', UploadedFile::fake()->image('laboratorio.jpg', 1600, 900))
            ->call('save')
            ->assertHasNoErrors();

        $page = PageContent::where('page', 'home')->firstOrFail();

        $this->assertSame("Creamos ideas\nque toman forma.", data_get($page->content, 'hero.title'));
        Storage::disk('public')->assertExists(data_get($page->content, 'hero.image'));
        $this->get('/')->assertOk()->assertSee('Creamos ideas');
    }
}
