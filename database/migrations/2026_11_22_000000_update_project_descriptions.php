<?php

use App\Models\PageContent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $page = DB::table('page_contents')->where('page', 'home')->first();
        if (! $page) {
            return;
        }

        $content = json_decode($page->content, true, 512, JSON_THROW_ON_ERROR);
        $projects = $content['projects']['items'] ?? [];
        foreach (PageContent::defaults()['projects']['items'] as $index => $project) {
            // Keep existing images and metadata while replacing the editorial text.
            $projects[$index] = array_replace($project, $projects[$index] ?? [], [
                'title' => $project['title'],
                'description' => $project['description'],
            ]);
        }
        $content['projects']['items'] = $projects;

        DB::table('page_contents')->where('id', $page->id)->update([
            'content' => json_encode($content, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Retain editorial content and subsequent administrator edits.
    }
};
