<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        foreach (File::allFiles(database_path('assets')) as $file) {
            Storage::disk('public')->put($file->getRelativePathname(), File::get($file->getPathname()));
        }

        $images = [
            'Talucell' => 'projects/talucell-dsc05400.webp',
            'Sensafeet' => 'projects/sensafeet-dsc05405.webp',
            'Desafío Maker' => 'projects/desafio-maker.webp',
            'Diseño e impresión' => 'projects/diseno-impresion-dsc05418.webp',
        ];
        foreach ($images as $title => $image) {
            $project = DB::table('projects')->where('title', $title)->first();
            if (! $project) {
                continue;
            }
            $values = ['cover_image' => $image, 'updated_at' => now()];
            if ($title === 'Talucell') {
                $gallery = json_decode($project->gallery ?? '[]', true);
                $gallery = array_values(array_filter($gallery, fn ($path) => Storage::disk('public')->exists($path)));
                $gallery[] = 'projects/talucell-galeria-original.jpg';
                $values['gallery'] = json_encode(array_values(array_unique($gallery)));
            }
            DB::table('projects')->where('id', $project->id)->update($values);
        }
        foreach ([
            'Prototipar para aprender: fabricación digital dentro del aula' => 'posts/prototipar-aprender.webp',
            'Cinco decisiones antes de imprimir tu primer prototipo funcional' => 'posts/primer-prototipo.webp',
        ] as $title => $image) {
            DB::table('posts')->where('title', $title)->update(['cover_image' => $image, 'updated_at' => now()]);
        }
        $page = DB::table('page_contents')->where('page', 'home')->first();
        if ($page) {
            $content = json_decode($page->content, true);
            $content['intro']['image'] = 'page-content/nosotros-comunidad.webp';
            DB::table('page_contents')->where('id', $page->id)->update(['content' => json_encode($content, JSON_UNESCAPED_UNICODE), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        // Keep published images and editorial content.
    }
};
