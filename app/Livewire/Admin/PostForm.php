<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    public ?Post $post = null;

    public string $title = '';

    public string $slug = '';

    public string $category = 'Investigación';

    public string $excerpt = '';

    public string $body = '';

    public string $status = 'draft';

    public $cover;

    public ?string $existingCover = null;

    public function mount(?Post $post = null): void
    {
        if ($post?->exists) {
            $this->post = $post;
            $this->fill($post->only(['title', 'slug', 'category', 'excerpt', 'body', 'status']));
            $this->existingCover = $post->cover_image;
        }
    }

    public function updatedTitle(string $value): void
    {
        if (! $this->post) {
            $this->slug = Str::slug($value);
        }
    }

    public function save(): mixed
    {
        $data = $this->validate([
            'title' => ['required', 'min:5', 'max:180'],
            'slug' => ['required', 'alpha_dash', 'max:190', Rule::unique('posts')->ignore($this->post?->id)],
            'category' => ['required', 'max:80'],
            'excerpt' => ['required', 'min:20', 'max:360'],
            'body' => ['required', 'min:50'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'cover' => ['nullable', 'image', 'max:5120'],
        ]);

        unset($data['cover']);
        if ($this->cover) {
            if ($this->existingCover) {
                Storage::disk('public')->delete($this->existingCover);
            }
            $data['cover_image'] = $this->cover->store('posts', 'public');
        }
        $data['published_at'] = $this->status === 'published'
            ? ($this->post?->published_at ?? now())
            : null;

        $this->post = Post::updateOrCreate(['id' => $this->post?->id], $data);

        session()->flash('success', 'La publicación fue guardada correctamente.');

        return $this->redirectRoute('admin.posts.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.post-form')->layout('components.layouts.admin', [
            'title' => $this->post ? 'Editar publicación' : 'Nueva publicación',
        ]);
    }
}
