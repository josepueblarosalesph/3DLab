<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable();
            $table->timestamps();
        });

        $page = DB::table('page_contents')->where('page', 'home')->first();
        $content = $page ? json_decode($page->content, true) : App\Models\PageContent::defaults();
        foreach ($content['projects']['items'] ?? [] as $index => $project) {
            DB::table('projects')->insert([
                'title' => $project['title'],
                'slug' => Str::slug($project['title']).'-'.($index + 1),
                'description' => $project['description'] ?? '',
                'cover_image' => $project['image'] ?? null,
                'gallery' => '[]',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
