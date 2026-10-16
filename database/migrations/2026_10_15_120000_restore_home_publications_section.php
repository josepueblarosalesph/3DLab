<?php

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
        $content['news']['enabled'] = true;
        $content['news']['title'] = "Investigación\nen movimiento.";

        DB::table('page_contents')->where('id', $page->id)->update([
            'content' => json_encode($content, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Preserve subsequent editorial changes.
    }
};
