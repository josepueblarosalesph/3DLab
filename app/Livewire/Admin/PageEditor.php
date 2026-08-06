<?php

namespace App\Livewire\Admin;

use App\Models\PageContent;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PageEditor extends Component
{
    use WithFileUploads;

    public array $content = [];

    public $heroImage;

    public array $projectImages = [];

    public array $removedImages = [];

    public function mount(): void
    {
        $this->content = PageContent::home()->content;
    }

    public function removeImage(string $path): void
    {
        if (! in_array($path, ['hero.image', 'projects.items.0.image', 'projects.items.1.image', 'projects.items.2.image'], true)) {
            return;
        }

        $current = data_get($this->content, $path);

        if ($current) {
            $this->removedImages[] = $current;
        }

        data_set($this->content, $path, null);

        if ($path === 'hero.image') {
            $this->reset('heroImage');
        } else {
            unset($this->projectImages[(int) str($path)->between('items.', '.image')->toString()]);
        }
    }

    public function restoreDefaults(): void
    {
        foreach (['hero.image', 'projects.items.0.image', 'projects.items.1.image', 'projects.items.2.image'] as $path) {
            $image = data_get($this->content, $path);
            if ($image) {
                $this->removedImages[] = $image;
            }
        }

        $this->content = PageContent::defaults();
        $this->reset('heroImage', 'projectImages');
    }

    public function save(): void
    {
        $this->validate([
            'content.hero.eyebrow' => ['required', 'string', 'max:120'],
            'content.hero.title' => ['required', 'string', 'max:120'],
            'content.hero.description' => ['required', 'string', 'max:360'],
            'content.hero.primary_cta' => ['required', 'string', 'max:60'],
            'content.hero.secondary_cta' => ['required', 'string', 'max:60'],
            'content.hero.strapline' => ['required', 'string', 'max:120'],
            'content.intro.eyebrow' => ['required', 'string', 'max:120'],
            'content.intro.title' => ['required', 'string', 'max:300'],
            'content.intro.description' => ['required', 'string', 'max:500'],
            'content.intro.stats.*.value' => ['required', 'string', 'max:20'],
            'content.intro.stats.*.label' => ['required', 'string', 'max:160'],
            'content.capabilities.title' => ['required', 'string', 'max:200'],
            'content.capabilities.description' => ['required', 'string', 'max:500'],
            'content.capabilities.items.*.title' => ['required', 'string', 'max:120'],
            'content.capabilities.items.*.description' => ['required', 'string', 'max:360'],
            'content.capabilities.items.*.tags' => ['required', 'string', 'max:120'],
            'content.projects.title' => ['required', 'string', 'max:200'],
            'content.projects.description' => ['required', 'string', 'max:500'],
            'content.projects.items.*.category' => ['required', 'string', 'max:50'],
            'content.projects.items.*.year' => ['required', 'string', 'max:10'],
            'content.projects.items.*.title' => ['required', 'string', 'max:160'],
            'content.projects.items.*.description' => ['required', 'string', 'max:300'],
            'content.network.title' => ['required', 'string', 'max:300'],
            'content.network.description' => ['required', 'string', 'max:500'],
            'content.news.title' => ['required', 'string', 'max:160'],
            'content.contact.eyebrow' => ['required', 'string', 'max:120'],
            'content.contact.title' => ['required', 'string', 'max:180'],
            'content.contact.description' => ['required', 'string', 'max:500'],
            'content.footer.eyebrow' => ['required', 'string', 'max:120'],
            'content.footer.title' => ['required', 'string', 'max:180'],
            'content.footer.description' => ['required', 'string', 'max:300'],
            'content.footer.email' => ['required', 'email', 'max:160'],
            'content.footer.location' => ['required', 'string', 'max:120'],
            'content.footer.instagram_url' => ['nullable', 'string', 'max:500'],
            'content.footer.linkedin_url' => ['nullable', 'string', 'max:500'],
            'heroImage' => ['nullable', 'image', 'max:8192'],
            'projectImages.*' => ['nullable', 'image', 'max:8192'],
        ], [], [
            'heroImage' => 'imagen de portada',
            'projectImages.*' => 'imagen de proyecto',
        ]);

        if ($this->heroImage) {
            $this->queueExistingImage('hero.image');
            data_set($this->content, 'hero.image', $this->heroImage->store('page-content', 'public'));
        }

        foreach ($this->projectImages as $index => $image) {
            if (! $image) {
                continue;
            }
            $path = "projects.items.{$index}.image";
            $this->queueExistingImage($path);
            data_set($this->content, $path, $image->store('page-content', 'public'));
        }

        PageContent::updateOrCreate(['page' => 'home'], ['content' => $this->content]);

        foreach (array_unique($this->removedImages) as $image) {
            if (str_starts_with($image, 'page-content/')) {
                Storage::disk('public')->delete($image);
            }
        }

        $this->reset('heroImage', 'projectImages', 'removedImages');
        $this->dispatch('content-saved');
        session()->flash('success', 'Los cambios ya están publicados en el sitio.');
    }

    private function queueExistingImage(string $path): void
    {
        $current = data_get($this->content, $path);
        if ($current) {
            $this->removedImages[] = $current;
        }
    }

    public function render()
    {
        return view('livewire.admin.page-editor')->layout('components.layouts.admin', [
            'title' => 'Editar sitio',
        ]);
    }
}
