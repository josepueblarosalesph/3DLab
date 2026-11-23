<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['title', 'subtitle', 'slug', 'description', 'cover_image', 'gallery'])]
class Project extends Model
{
    protected function casts(): array
    {
        return ['gallery' => 'array'];
    }

    public function excerpt(): string
    {
        return Str::limit(preg_replace('/\s+/u', ' ', $this->description), 160);
    }
}
