<?php

namespace Database\Seeders;

use App\Models\PageContent;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        PageContent::firstOrCreate(['page' => 'home'], ['content' => PageContent::defaults()]);

        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@openlab.cl')],
            ['name' => 'Equipo Open Lab', 'password' => Hash::make(env('ADMIN_PASSWORD', 'OpenLab2026!'))]
        );

        $posts = [
            [
                'title' => 'Del escáner al modelo: nuevas herramientas para planificación clínica',
                'slug' => 'del-escaner-al-modelo-planificacion-clinica',
                'category' => 'Salud',
                'excerpt' => 'Exploramos un flujo de trabajo que convierte información médica en modelos anatómicos físicos para preparar intervenciones complejas.',
                'body' => '<h2>La anatomía como información tangible</h2><p>La fabricación aditiva permite transformar datos de imagenología en modelos físicos que facilitan la conversación entre equipos clínicos, investigadores y pacientes.</p><p>En Open Lab trabajamos mediante ciclos de segmentación, impresión, evaluación y ajuste. Cada iteración busca responder una pregunta clínica concreta, manteniendo trazabilidad sobre materiales, tolerancias y decisiones de diseño.</p><h2>Colaborar desde el inicio</h2><p>El valor no está únicamente en la pieza terminada. Está en reunir conocimiento médico, ingeniería y capacidades de fabricación desde la definición del problema.</p>',
            ],
            [
                'title' => 'Prototipar para aprender: fabricación digital dentro del aula',
                'slug' => 'prototipar-para-aprender',
                'category' => 'Academia',
                'excerpt' => 'Una metodología práctica para conectar asignaturas, estudiantes y desafíos reales mediante procesos iterativos de diseño.',
                'body' => '<h2>Aprender haciendo</h2><p>Cuando una idea se convierte rápidamente en un objeto, aparecen preguntas que no eran visibles en la pantalla. Materiales, ergonomía, ensamblaje y uso real pasan a ser parte del aprendizaje.</p><p>Nuestros workshops integran design thinking, modelado y fabricación digital en experiencias breves, rigurosas y accesibles.</p>',
            ],
            [
                'title' => 'Cinco decisiones antes de imprimir tu primer prototipo funcional',
                'slug' => 'cinco-decisiones-primer-prototipo',
                'category' => 'Guías',
                'excerpt' => 'Objetivo, escala, material, tolerancia y validación: una guía breve para aprovechar mejor cada ciclo de fabricación.',
                'body' => '<h2>La impresión comienza antes de la máquina</h2><p>Un buen prototipo no intenta resolver todo al mismo tiempo. Define qué necesita aprender, qué variables mantendrá fijas y cómo se evaluará el resultado.</p><p>Elegir tecnología y material solo tiene sentido después de aclarar la función del prototipo y el contexto donde será probado.</p>',
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post + ['status' => 'published', 'published_at' => now()]);
        }
    }
}
