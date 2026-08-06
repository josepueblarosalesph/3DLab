<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['page', 'content'])]
class PageContent extends Model
{
    protected function casts(): array
    {
        return ['content' => 'array'];
    }

    public static function home(): self
    {
        $record = static::firstOrCreate(
            ['page' => 'home'],
            ['content' => static::defaults()]
        );

        $record->content = array_replace_recursive(static::defaults(), $record->content ?? []);

        return $record;
    }

    public static function defaults(): array
    {
        return [
            'hero' => [
                'eyebrow' => 'Hub de innovación tecnológica & I+D',
                'title' => "Prototipamos\nel futuro.",
                'description' => 'Transformamos ideas complejas en soluciones tecnológicas con impacto real, conectando academia, investigación, industria y salud.',
                'primary_cta' => 'Explora capacidades',
                'secondary_cta' => 'Inicia un proyecto',
                'strapline' => 'Diseñar · Fabricar · Validar',
                'image' => null,
            ],
            'intro' => [
                'eyebrow' => 'Un ecosistema de desarrollo',
                'title' => 'Más que un laboratorio: un espacio abierto para convertir conocimiento en soluciones.',
                'description' => 'No solo fabricamos piezas. Articulamos talento, tecnología y metodologías avanzadas dentro de un ecosistema universitario y clínico que acelera la transferencia tecnológica.',
                'stats' => [
                    ['value' => '+120', 'label' => 'Prototipos y soluciones desarrolladas'],
                    ['value' => '03', 'label' => 'Líneas estratégicas: academia, industria y salud'],
                    ['value' => '100%', 'label' => 'Conectados con redes de investigación y transferencia'],
                ],
            ],
            'capabilities' => [
                'title' => "Tecnología aplicada\na desafíos reales.",
                'description' => 'Acompañamos desde la pregunta inicial hasta el prototipo validado, combinando infraestructura avanzada y conocimiento multidisciplinario.',
                'items' => [
                    ['title' => 'Fabricación digital & prototipado', 'description' => 'Impresión 3D avanzada, escaneo, corte y manufactura para acelerar procesos de investigación y desarrollo.', 'tags' => 'FDM · SLA · SLS · CNC'],
                    ['title' => 'I+D para startups & empresas', 'description' => 'Diseño, validación y escalamiento de productos para emprendimientos científico-tecnológicos y equipos de innovación.', 'tags' => 'DISEÑO · ITERACIÓN · VALIDACIÓN'],
                    ['title' => 'Ingeniería & prototipado médico', 'description' => 'Modelos anatómicos, fantomas, simuladores y dispositivos desarrollados junto a equipos clínicos.', 'tags' => 'SALUD · SIMULACIÓN · PRECISIÓN'],
                    ['title' => 'Formación & workshops', 'description' => 'Talleres prácticos y metodologías de diseño integradas a asignaturas, equipos y comunidades.', 'tags' => 'MAKER · DESIGN THINKING · STEAM'],
                ],
            ],
            'projects' => [
                'title' => "Cuando las disciplinas\nse encuentran.",
                'description' => 'Proyectos que muestran cómo la colaboración multidisciplinaria se convierte en innovación aplicada.',
                'items' => [
                    ['category' => 'Salud', 'year' => '2026', 'title' => 'Simulador anatómico de alta fidelidad', 'description' => 'Planificación quirúrgica y validación clínica conjunta.', 'image' => null],
                    ['category' => 'Tecnología', 'year' => '2026', 'title' => 'Dispositivo IoT para monitoreo industrial', 'description' => 'Del concepto al primer lote funcional.', 'image' => null],
                    ['category' => 'Academia', 'year' => '2025', 'title' => 'Desafío Maker interdisciplinario', 'description' => 'Estudiantes conectados con problemas reales.', 'image' => null],
                ],
            ],
            'network' => [
                'title' => 'Conectamos capacidades que por separado no generarían el mismo impacto.',
                'description' => 'Nuestra ventaja está en habitar un ecosistema universitario y clínico robusto, articulando expertises bajo estándares rigurosos de calidad, transparencia y ética.',
            ],
            'news' => ['title' => "Investigación\nen movimiento."],
            'contact' => [
                'eyebrow' => 'Inicia una colaboración',
                'title' => "¿Qué podemos\nprototipar juntos?",
                'description' => 'Cuéntanos brevemente tu desafío. Nuestro equipo revisará el requerimiento y te contactará para definir el siguiente paso.',
            ],
            'footer' => [
                'eyebrow' => 'Hagamos algo relevante',
                'title' => "Ideas abiertas.\nImpacto real.",
                'description' => 'Hub de innovación tecnológica, fabricación digital e I+D.',
                'email' => 'contacto@openlab.cl',
                'location' => 'Santiago, Chile',
                'instagram_url' => '#',
                'linkedin_url' => '#',
            ],
        ];
    }
}
