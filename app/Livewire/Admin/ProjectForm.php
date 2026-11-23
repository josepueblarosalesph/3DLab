<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectForm extends Component
{
    use WithFileUploads;

    public ?Project $project = null;
    public string $title = '';
    public ?string $subtitle = '';
    public string $slug = '';
    public string $description = '';
    public $cover;
    public ?string $existingCover = null;
    public array $photos = [];
    public array $gallery = [];

    public function mount(?Project $project = null): void
    {
        if ($project?->exists) {
            $this->project = $project;
            $this->fill($project->only(['title', 'subtitle', 'slug', 'description']));
            $this->existingCover = $project->cover_image;
            $this->gallery = $project->gallery ?? [];
        }
    }

    public function updatedTitle(string $value): void
    {
        if (! $this->project) {
            $this->slug = Str::slug($value);
        }
    }

    public function removePhoto(int $index): void
    {
        unset($this->gallery[$index]);
        $this->gallery = array_values($this->gallery);
    }

    public function removeCover(): void
    {
        $this->existingCover = null;
        $this->reset('cover');
    }

    public function save(): mixed
    {
        $data = $this->validate([
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:190', Rule::unique('projects')->ignore($this->project?->id)],
            'description' => ['required', 'string', 'max:50000'],
            'cover' => ['nullable', 'image', 'max:8192'],
            'photos' => ['array', 'max:30'],
            'photos.*' => ['image', 'max:8192'],
        ]);
        // Only retain persisted gallery paths from this project.
        $gallery = array_values(array_intersect($this->gallery, $this->project?->gallery ?? []));
        foreach ($this->photos as $photo) {
            $gallery[] = $photo->store('projects', 'public');
        }
        $cover = $this->cover ? $this->cover->store('projects', 'public') : ($this->existingCover ? $this->project?->cover_image : null);
        Project::updateOrCreate(['id' => $this->project?->id], [
            'title' => $data['title'], 'subtitle' => $data['subtitle'], 'slug' => $data['slug'], 'description' => $data['description'],
            'cover_image' => $cover, 'gallery' => $gallery,
        ]);
        session()->flash('success', 'El proyecto fue guardado correctamente.');
        return $this->redirectRoute('admin.projects.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.project-form')->layout('components.layouts.admin', ['title' => $this->project ? 'Editar proyecto' : 'Nuevo proyecto']);
    }
}
