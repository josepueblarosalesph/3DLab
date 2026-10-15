<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $updates = json_decode(<<<'JSON'
{
    "hero": {
        "eyebrow": "Laboratorio de fabricación digital e innovación",
        "title": "Transformamos\nideas en soluciones.",
        "description": "Somos un laboratorio de fabricación digital e innovación que conecta diseño, tecnología y experimentación para desarrollar proyectos concretos.",
        "primary_cta": "Explora capacidades",
        "secondary_cta": "Inicia un proyecto",
        "strapline": "Diseño · Tecnología · Experimentación"
    },
    "intro": {
        "eyebrow": "Como parte de la universidad",
        "title": "Desde la universidad hacia la comunidad",
        "description": "Como parte de la universidad, OpenLab conecta el conocimiento académico con la experimentación práctica. Generamos vínculos entre estudiantes, docentes, investigadores, funcionarios, empresas y comunidad, creando oportunidades para desarrollar proyectos que integren distintas disciplinas y perspectivas.",
        "stats": []
    },
    "capabilities": {
        "title": "Tecnología aplicada\na desafíos reales",
        "description": "Nuestro trabajo se adapta a las necesidades de cada proyecto. Podemos participar en distintas etapas del proceso:",
        "items": [
            {
                "title": "Diseño y desarrollo",
                "description": "Convertimos ideas, requerimientos y conceptos en propuestas concretas, modelos digitales y soluciones fabricables.",
                "tags": ""
            },
            {
                "title": "Prototipado",
                "description": "Fabricamos modelos y prototipos que permiten probar, evaluar y mejorar una idea antes de avanzar hacia una solución definitiva.",
                "tags": ""
            },
            {
                "title": "Fabricación digital",
                "description": "Utilizamos distintas tecnologías y procesos de fabricación para producir piezas, componentes, modelos y productos personalizados.",
                "tags": ""
            },
            {
                "title": "Experimentación y testeo",
                "description": "Exploramos nuevas formas de utilizar materiales y tecnologías para resolver problemas y abrir nuevas posibilidades.",
                "tags": ""
            },
            {
                "title": "Capacitación y acompañamiento",
                "description": "Compartimos conocimientos y herramientas para que estudiantes, equipos de trabajo y organizaciones puedan desarrollar sus propias capacidades de fabricación digital.",
                "tags": ""
            }
        ]
    },
    "projects": {
        "title": "Proyectos",
        "description": "Cada proyecto que desarrollamos es una oportunidad para explorar nuevas ideas, tecnologías y formas de resolver problemas. Desde prototipos funcionales y piezas personalizadas hasta desarrollos experimentales, cada proyecto refleja una combinación particular de diseño, fabricación, tecnología y colaboración.",
        "items": [
            {
                "category": "",
                "year": "",
                "title": "Cell4cells",
                "description": "",
                "image": null
            },
            {
                "category": "",
                "year": "",
                "title": "Sensafeet",
                "description": "",
                "image": null
            },
            {
                "category": "",
                "year": "",
                "title": "Desafío Maker",
                "description": "",
                "image": null
            }
        ]
    },
    "network": {
        "title": "Nuestra misión es hacer que las ideas puedan pasar del concepto a la realidad",
        "description": "Academia × Industria × Comunidad"
    },
    "news": {
        "title": "Novedades",
        "enabled": false
    },
    "contact": {
        "eyebrow": "Contacto",
        "title": "¿Tienes una idea?\nHablemos.",
        "description": "Si tienes un proyecto, una necesidad o simplemente quieres explorar qué podemos hacer juntos, escríbenos. Cuéntanos brevemente qué quieres desarrollar y, si ya lo tienes definido, comparte información como dimensiones, materiales, cantidades, archivos o referencias. Nuestro equipo revisará tu solicitud y te orientará sobre las posibilidades de desarrollo."
    }
}
JSON, true, 512, JSON_THROW_ON_ERROR);

        $page = DB::table('page_contents')->where('page', 'home')->first();
        if (! $page) {
            return;
        }

        $content = json_decode($page->content, true, 512, JSON_THROW_ON_ERROR);
        foreach ($updates as $section => $values) {
            // Replace editorial lists completely so old projects and indicators do not survive.
            $content[$section] = array_replace($content[$section] ?? [], $values);
        }
        $content['footer']['description'] = 'Laboratorio de fabricación digital e innovación.';

        DB::table('page_contents')->where('id', $page->id)->update([
            'content' => json_encode($content, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Editorial content is retained to avoid overwriting subsequent administrator edits.
    }
};
