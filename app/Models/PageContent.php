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
                'eyebrow' => 'Laboratorio de fabricación digital e innovación',
                'title' => "Transformamos\nideas en soluciones.",
                'description' => 'Somos un laboratorio de fabricación digital e innovación que conecta diseño, tecnología y experimentación para desarrollar proyectos concretos.',
                'primary_cta' => 'Explora capacidades',
                'secondary_cta' => 'Inicia un proyecto',
                'strapline' => 'Diseño · Tecnología · Experimentación',
                'image' => null,
            ],
            'intro' => [
                'eyebrow' => 'Como parte de la universidad',
                'title' => 'Desde la universidad hacia la comunidad',
                'description' => 'Como parte de la universidad, OpenLab conecta el conocimiento académico con la experimentación práctica. Generamos vínculos entre estudiantes, docentes, investigadores, funcionarios, empresas y comunidad, creando oportunidades para desarrollar proyectos que integren distintas disciplinas y perspectivas.',
                'stats' => [],
                'image' => null,
            ],
            'capabilities' => [
                'title' => "Tecnología aplicada\na desafíos reales",
                'description' => 'Nuestro trabajo se adapta a las necesidades de cada proyecto. Podemos participar en distintas etapas del proceso:',
                'items' => [
                    ['title' => 'Diseño y desarrollo', 'description' => 'Convertimos ideas, requerimientos y conceptos en propuestas concretas, modelos digitales y soluciones fabricables.', 'tags' => ''],
                    ['title' => 'Prototipado', 'description' => 'Fabricamos modelos y prototipos que permiten probar, evaluar y mejorar una idea antes de avanzar hacia una solución definitiva.', 'tags' => ''],
                    ['title' => 'Fabricación digital', 'description' => 'Utilizamos distintas tecnologías y procesos de fabricación para producir piezas, componentes, modelos y productos personalizados.', 'tags' => ''],
                    ['title' => 'Experimentación y testeo', 'description' => 'Exploramos nuevas formas de utilizar materiales y tecnologías para resolver problemas y abrir nuevas posibilidades.', 'tags' => ''],
                    ['title' => 'Capacitación y acompañamiento', 'description' => 'Compartimos conocimientos y herramientas para que estudiantes, equipos de trabajo y organizaciones puedan desarrollar sus propias capacidades de fabricación digital.', 'tags' => ''],
                ],
            ],
            'equipment' => [
                'title' => 'Equipamiento y espacio',
                'description' => 'Nuestra infraestructura combina distintas tecnologías de fabricación digital con herramientas y áreas de trabajo que permiten abordar proyectos de diferentes escalas y niveles de complejidad.',
                'items' => [
                    ['title' => 'Fabricación aditiva', 'description' => 'Impresión 3D FDM'],
                    ['title' => 'Corte y grabado', 'description' => 'Tecnologías para cortar, marcar y trabajar materiales de diferentes formatos.'],
                    ['title' => 'Diseño y modelación digital', 'description' => 'Herramientas de diseño y modelación que permiten desarrollar y preparar proyectos para su fabricación.'],
                    ['title' => 'Instrumentación y herramientas', 'description' => 'Equipamiento complementario para ensamblar, ajustar, medir y trabajar los proyectos durante sus distintas etapas.'],
                ],
                'invitation' => 'Cuéntanos brevemente qué quieres desarrollar y, si ya lo tienes definido, comparte información como dimensiones, materiales, cantidades, archivos o referencias. Nuestro equipo revisará tu solicitud y te orientará sobre las posibilidades de desarrollo.',
            ],
            'projects' => [
                'title' => 'Proyectos',
                'description' => 'Cada proyecto que desarrollamos es una oportunidad para explorar nuevas ideas, tecnologías y formas de resolver problemas. Desde prototipos funcionales y piezas personalizadas hasta desarrollos experimentales, cada proyecto refleja una combinación particular de diseño, fabricación, tecnología y colaboración.',
                'items' => [
                    ['category' => '', 'year' => '', 'title' => 'Talucell: Diseño de jeringas para procedimientos con células madre', 'description' => 'Proyecto realizado en conjunto con Cells for Cells, donde se desarrollaron las jeringas para las terapias de tobillo con células madre.

El desafío consistió en lograr una jeringa que permitiera el depósito del tratamiento en la zona específica, manteniendo la presión interior y evitando la pérdida del material.', 'image' => null],
                    ['category' => '', 'year' => '', 'title' => 'Sensafeet: Sistema de monitoreo en tiempo real para la prevención de úlceras del pie diabético', 'description' => 'La tecnología Sensa Feet consiste en una plantilla a medida con sensores de presión y temperatura que monitorea en tiempo real el pie del paciente, evitando la formación de úlceras. Además, el sistema integra una herramienta telemédica para acercar al paciente al profesional de salud.

En OpenLab, desarrollamos en conjunto con Sensafeet el diseño de plantillas impresas en 3D con TPU, material elástico que con diferentes patrones de relleno (infill) pueden generar diferentes resistencias al peso.', 'image' => null],
                    ['category' => '', 'year' => '', 'title' => 'Desafío Maker: Diseño e impresión de dispositivos de asistencia para terapia ocupacional', 'description' => 'En el marco del proyecto Desafío Maker que se realizó en conjunto con Teletón, alumnos de las carreras de Terapia Ocupacional, Enfermería e Ingeniería desarrollaron productos para mejorar los tratamientos de rehabilitación.

Para esto se utilizaron técnicas de modelado e impresión 3D para prototipar los objetos y testarlos.', 'image' => null],
                    ['category' => '', 'year' => '', 'title' => 'Diseño e impresión de modelo anatómico intraoral', 'description' => 'Proyecto realizado junto a la profesora Kiyoko Suzuki, cirujana dentista, donde se escanearon e imprimieron modelos anatómicos de la dentadura de un niño.

Se utilizó para conocer más el alcance del escáner intraoral y su definición en el modelo 3D.', 'image' => null],
                ],
            ],
            'network' => [
                'title' => 'Nuestra misión es hacer que las ideas puedan pasar del concepto a la realidad',
                'description' => 'Academia × Industria × Comunidad',
            ],
            'news' => ['title' => "Investigación\nen movimiento.", 'enabled' => true],
            'contact' => [
                'eyebrow' => 'Contacto',
                'title' => "¿Tienes una idea?\nHablemos.",
                'description' => 'Si tienes un proyecto, una necesidad o simplemente quieres explorar qué podemos hacer juntos, escríbenos. Cuéntanos brevemente qué quieres desarrollar y, si ya lo tienes definido, comparte información como dimensiones, materiales, cantidades, archivos o referencias. Nuestro equipo revisará tu solicitud y te orientará sobre las posibilidades de desarrollo.',
            ],
            'footer' => [
                'eyebrow' => 'Hagamos algo relevante',
                'title' => "Ideas abiertas.\nImpacto real.",
                'description' => 'Laboratorio de fabricación digital e innovación.',
                'email' => 'contacto@openlab.cl',
                'location' => 'Santiago, Chile',
                'instagram_url' => '#',
                'linkedin_url' => '#',
            ],
        ];
    }
}
