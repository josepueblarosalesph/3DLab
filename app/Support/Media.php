<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class Media
{
    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (! str_contains($path, '..') && is_file(public_path('media/'.$path))) {
            return asset('media/'.$path);
        }

        return Storage::disk('public')->url($path);
    }
}
