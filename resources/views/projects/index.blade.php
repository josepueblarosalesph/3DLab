<x-public-layout title="Proyectos — Open Lab" :site-content="$content">
    <section class="projects-section projects-listing">
        <div class="project-intro">
            <span class="eyebrow light">Diseño · Fabricación · Colaboración</span>
            <h1>{{ data_get($content, 'projects.title') }}</h1>
            <p>{{ data_get($content, 'projects.description') }}</p>
        </div>
        @include('projects.grid')
        @if($projects->isEmpty())<p>Próximamente compartiremos nuevos proyectos.</p>@endif
    </section>
</x-public-layout>
