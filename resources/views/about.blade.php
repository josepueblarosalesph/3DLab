<x-public-layout title="Quiénes somos — Open Lab" :site-content="$content">
    <section class="page-hero about-hero">
        <a class="about-breadcrumb" href="{{ route('home') }}">Inicio <span aria-hidden="true">/</span></a>
        <span class="eyebrow">Open Lab · Universidad de los Andes</span>
        <h1>Quiénes somos.</h1>
        <p>{{ data_get($content, 'hero.description') }}</p>
        <a class="about-jump" href="#equipo">Conoce al equipo <span aria-hidden="true">↓</span></a>
    </section>

    <section class="section about-intro">
        <div class="section-index"><span>01</span><span>El laboratorio</span></div>
        <div class="section-heading split">
            <h2>{{ data_get($content, 'intro.title') }}</h2>
            <div><span class="eyebrow">{{ data_get($content, 'intro.eyebrow') }}</span><p>{{ data_get($content, 'intro.description') }}</p></div>
        </div>
        <div class="about-purpose">
            <span class="eyebrow">Nuestro propósito</span>
            <h3>{{ data_get($content, 'network.title') }}</h3>
            <span class="about-purpose-mark" aria-hidden="true">↗</span>
        </div>
    </section>

    <section id="equipo" class="section team-section" aria-labelledby="team-title">
        <div class="section-index"><span>02</span><span>Personas</span></div>
        <div class="section-heading split">
            <h2 id="team-title">Nuestro equipo.</h2>
            <p class="team-demo-note">Vista de prueba: los nombres y las fotografías son demostrativos y serán reemplazados por los del equipo de Open Lab.</p>
        </div>
        @php
            $demoTeam = [
                ['name' => 'Camila Rojas', 'photo' => 'camila'],
                ['name' => 'Tomás Herrera', 'photo' => 'tomas'],
                ['name' => 'Valentina Soto', 'photo' => 'valentina'],
                ['name' => 'Nicolás Fuentes', 'photo' => 'nicolas'],
                ['name' => 'Josefa Morales', 'photo' => 'josefa'],
                ['name' => 'Matías Silva', 'photo' => 'matias'],
            ];
        @endphp
        <div class="team-grid">
            @foreach($demoTeam as $person)
                <article class="team-card">
                    <div class="team-photo"><img src="{{ asset('images/team-demo/'.$person['photo'].'.jpg') }}" alt="Fotografía de prueba para el perfil de {{ $person['name'] }}" width="128" height="128" loading="lazy"></div>
                    <span class="team-card-index" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $person['name'] }}</h3>
                </article>
            @endforeach
        </div>
    </section>

    <section id="comunidad" class="section about-community" aria-labelledby="community-title">
        <div class="section-index"><span>03</span><span>Las personas y sus conexiones</span></div>
        <div class="section-heading split">
            <h2 id="community-title">Una comunidad.<br>Distintas miradas.</h2>
            <p>Conectamos academia, industria y comunidad para desarrollar proyectos que integren distintas disciplinas y perspectivas.</p>
        </div>
        <div class="community-list">
            <details class="community-profile" open>
                <summary><span class="community-initial" aria-hidden="true">A</span><span><small>01 / Academia</small><strong>Conocimiento que se comparte</strong></span><span class="community-toggle" aria-hidden="true"></span></summary>
                <div class="community-bio"><p>Estudiantes, docentes, investigadores y funcionarios encuentran un espacio para conectar el conocimiento académico con la experimentación práctica y desarrollar proyectos entre distintas disciplinas.</p></div>
            </details>
            <details class="community-profile">
                <summary><span class="community-initial" aria-hidden="true">I</span><span><small>02 / Industria</small><strong>Desafíos que nos conectan</strong></span><span class="community-toggle" aria-hidden="true"></span></summary>
                <div class="community-bio"><p>Colaboramos con empresas y equipos de trabajo para explorar necesidades, desarrollar propuestas y avanzar desde una idea hacia modelos, prototipos y soluciones fabricables.</p></div>
            </details>
            <details class="community-profile">
                <summary><span class="community-initial" aria-hidden="true">C</span><span><small>03 / Comunidad</small><strong>Ideas que abren posibilidades</strong></span><span class="community-toggle" aria-hidden="true"></span></summary>
                <div class="community-bio"><p>Abrimos oportunidades de encuentro, aprendizaje y colaboración para que personas y organizaciones puedan explorar la fabricación digital y desarrollar sus propias capacidades.</p></div>
            </details>
        </div>
    </section>

    <section class="section about-next">
        <span class="eyebrow">Trabajemos juntos</span>
        <div class="section-heading split">
            <h2>Tu idea también<br>tiene un lugar aquí.</h2>
            <div><p>{{ data_get($content, 'equipment.invitation') }}</p><a class="about-cta" href="{{ route('home') }}#contacto">Conversemos sobre tu proyecto <span aria-hidden="true">↗</span></a></div>
        </div>
    </section>
</x-public-layout>
