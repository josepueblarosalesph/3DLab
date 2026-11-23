<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('projects')
            ->where('title', 'Diseño e impresión de modelo anatómico intraoral')
            ->update([
                'title' => 'Diseño e impresión',
                'subtitle' => 'de modelo anatómico intraoral',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('projects')
            ->where('title', 'Diseño e impresión')
            ->where('subtitle', 'de modelo anatómico intraoral')
            ->update([
                'title' => 'Diseño e impresión de modelo anatómico intraoral',
                'subtitle' => null,
                'updated_at' => now(),
            ]);
    }
};
