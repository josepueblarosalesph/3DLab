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
        $response->assertSee('Transformamos');
        $response->assertSee('Capacitación y acompañamiento');
        $response->assertSee('Talucell');
        $response->assertSee('Diseño e impresión');
        $response->assertSee('de modelo anatómico intraoral');
        $response->assertDontSee('Foco estratégico');
        $response->assertSee('news-section');
        $response->assertSee('en movimiento.');
        $response->assertSee('Ver todas las publicaciones');
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
    public function test_editor_can_save_and_replace_a_publication_cover(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        Livewire::test(\App\Livewire\Admin\PostForm::class)
            ->set('title', 'Publicación con imagen')
            ->set('slug', 'publicacion-con-imagen')
            ->set('excerpt', str_repeat('Resumen de prueba. ', 3))
            ->set('body', str_repeat('Contenido de la publicación. ', 4))
            ->set('cover', UploadedFile::fake()->image('portada.jpg')->size(4096))
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.posts.index'));

        $post = \App\Models\Post::where('slug', 'publicacion-con-imagen')->firstOrFail();
        $original = $post->cover_image;
        $this->assertNotNull($original);
        Storage::disk('public')->assertExists($original);

        Livewire::test(\App\Livewire\Admin\PostForm::class, ['post' => $post])
            ->set('cover', UploadedFile::fake()->image('nueva.jpg'))
            ->call('save')
            ->assertHasNoErrors();

        Storage::disk('public')->assertExists($post->fresh()->cover_image);
        Storage::disk('public')->assertMissing($original);
    }

}
