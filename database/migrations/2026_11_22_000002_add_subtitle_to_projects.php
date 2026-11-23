<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title');
        });

        foreach (DB::table('projects')->get() as $project) {
            if (str_contains($project->title, ':')) {
                [$title, $subtitle] = explode(':', $project->title, 2);
                DB::table('projects')->where('id', $project->id)->update([
                    'title' => trim($title),
                    'subtitle' => trim($subtitle),
                ]);
            }
        }
    }

    public function down(): void
    {
        foreach (DB::table('projects')->whereNotNull('subtitle')->get() as $project) {
            DB::table('projects')->where('id', $project->id)->update([
                'title' => $project->title.': '.$project->subtitle,
            ]);
        }
        Schema::table('projects', fn (Blueprint $table) => $table->dropColumn('subtitle'));
    }
};
