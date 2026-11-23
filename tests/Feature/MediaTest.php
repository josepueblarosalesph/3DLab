<?php

namespace Tests\Feature;

use App\Support\Media;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaTest extends TestCase
{
    public function test_bundled_images_are_served_without_local_storage(): void
    {
        Storage::fake('public');
        $path = 'projects/desafio-maker.webp';
        Storage::disk('public')->assertMissing($path);
        $this->assertSame(asset('media/'.$path), Media::url($path));
        $this->assertFileExists(public_path('media/'.$path));
    }

    public function test_uploaded_images_use_the_public_disk_url(): void
    {
        Storage::fake('public');
        $this->assertSame(Storage::disk('public')->url('projects/upload.webp'), Media::url('projects/upload.webp'));
        $this->assertNull(Media::url(null));
    }
}
