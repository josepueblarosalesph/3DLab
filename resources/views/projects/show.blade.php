<x-public-layout :title="$project->title.' — Open Lab'">
    <article class="project-detail">
        <div class="project-detail-copy">
            <header>
                <span class="eyebrow">Proyectos · OpenLab</span>
                <h1>{{ $project->title }}</h1>
                @if($project->subtitle)<p class="project-detail-subtitle">{{ $project->subtitle }}</p>@endif
            </header>
            <div class="project-detail-description">{!! nl2br(e($project->description)) !!}</div>
            <a href="{{ route('home') }}#proyectos" class="project-detail-back">← Volver a proyectos</a>
        </div>
        @if($project->cover_image || $project->gallery)
            <div class="project-detail-media" aria-label="Imágenes del proyecto">
                @if($project->cover_image)<img class="project-detail-cover" src="{{ \App\Support\Media::url($project->cover_image) }}" alt="{{ $project->title }}">@endif
                @if($project->gallery)
                    <section class="project-gallery" aria-label="Galería de fotos">
                        <h2 class="sr-only">Galería de fotos</h2>
                        @foreach($project->gallery as $photo)
                            <a href="{{ \App\Support\Media::url($photo) }}" target="_blank" rel="noopener"><img src="{{ \App\Support\Media::url($photo) }}" alt="{{ $project->title }} — foto {{ $loop->iteration }}" loading="lazy"></a>
                        @endforeach
                    </section>
                @endif
            </div>
        @endif
    </article>
</x-public-layout>
