<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Match stable slugs so edited headlines do not prevent image assignment.
        foreach ([
            'del-escaner-al-modelo-planificacion-clinica' => 'posts/planificacion-clinica.webp',
            'prototipar-para-aprender' => 'posts/prototipar-aprender.webp',
            'cinco-decisiones-primer-prototipo' => 'posts/primer-prototipo.webp',
        ] as $slug => $image) {
            DB::table('posts')->where('slug', $slug)->update([
                'cover_image' => $image,
                'updated_at' => now(),
            ]);
        }

        $page = DB::table('page_contents')->where('page', 'home')->first();
        if ($page) {
            $content = json_decode($page->content, true, 512, JSON_THROW_ON_ERROR);
            $content['intro']['image'] = 'page-content/nosotros-comunidad.webp';
            DB::table('page_contents')->where('id', $page->id)->update([
                'content' => json_encode($content, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Preserve published editorial images.
    }
};
