<?php

namespace Tests\Feature;

use App\Livewire\Admin\ProjectForm;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_links_to_full_project_without_showing_entire_description(): void
    {
        $project = Project::firstOrFail();
        $project->update(['description' => str_repeat('Texto del proyecto. ', 20).'Final exclusivo de la ficha.']);
        $this->get('/')->assertOk()->assertSee('Ver el Proyecto')->assertSee(route('projects.show', $project))->assertDontSee('Final exclusivo de la ficha.');
        $this->get(route('projects.show', $project))->assertOk()->assertSee('Final exclusivo de la ficha.');
        $this->get('/proyectos')->assertOk()->assertSee($project->title)->assertSee(route('projects.show', $project));
        $this->get('/')->assertSee('Ver todos los proyectos')->assertSee(route('projects.index'));
        $this->get('/proyectos/no-existe')->assertNotFound();
        $this->get('/admin/proyectos')->assertRedirect('/admin/login');
    }

    public function test_admin_can_create_and_edit_project_with_gallery(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
        Livewire::test(ProjectForm::class)
            ->set('title', 'Nuevo proyecto de prueba')->set('subtitle', 'Subtítulo de prueba')->set('slug', 'nuevo-proyecto')
            ->set('description', 'Descripción completa del nuevo proyecto.')
            ->set('cover', UploadedFile::fake()->image('destacada.jpg'))
            ->set('photos', [UploadedFile::fake()->image('galeria.jpg')])
            ->call('save')->assertHasNoErrors()->assertRedirect(route('admin.projects.index'));
        $project = Project::where('slug', 'nuevo-proyecto')->firstOrFail();
        $this->assertSame('Subtítulo de prueba', $project->subtitle);
        $this->get('/proyectos')->assertSee('Subtítulo de prueba');
        Storage::disk('public')->assertExists($project->cover_image);
        Storage::disk('public')->assertExists($project->gallery[0]);
        $this->get(route('projects.show', $project))->assertOk()->assertSee('Galería de fotos')->assertSee('Subtítulo de prueba')->assertSee($project->gallery[0]);
        $this->get(route('admin.projects.index'))->assertOk()->assertSee($project->title);
        $this->get(route('admin.projects.edit', $project))->assertOk();
        Livewire::test(ProjectForm::class, ['project' => $project])
            ->set('title', 'Título actualizado')->call('removePhoto', 0)->call('removeCover')
            ->call('save')->assertHasNoErrors();
        $this->assertSame([], $project->fresh()->gallery);
        $this->assertNull($project->fresh()->cover_image);
        $this->assertSame('Título actualizado', $project->fresh()->title);
    }
}
