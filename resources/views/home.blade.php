<x-public-layout :site-content="$content">
    <section class="hero">
        <div class="hero-topline"><span>{{ data_get($content, 'hero.eyebrow') }}</span><span>33.4° S · 70.6° W</span></div>
        <div class="hero-copy">
            <h1>{!! nl2br(e(data_get($content, 'hero.title'))) !!}</h1>
            <p>{{ data_get($content, 'hero.description') }}</p>
            <div class="hero-actions"><a href="#capacidades">{{ data_get($content, 'hero.primary_cta') }} <span class="direction-icon" aria-hidden="true">↓</span></a><a href="#contacto">{{ data_get($content, 'hero.secondary_cta') }} <span class="direction-icon" aria-hidden="true">↗</span></a></div>
        </div>
        <div class="hero-index"><span>OPEN / 01</span><span>{{ data_get($content, 'hero.strapline') }}</span></div>
    </section>

    <section id="acerca" class="section intro-section">
        <div class="section-index"><span>01</span><span>Nosotros</span></div>
        <div class="intro-main">
            <span class="eyebrow">{{ data_get($content, 'intro.eyebrow') }}</span>
            <h2>{{ data_get($content, 'intro.title') }}</h2>
            <div class="intro-summary">
                <p>{{ data_get($content, 'intro.description') }}</p>
                <a class="about-cta" href="{{ route('about') }}">Conoce quiénes somos <span aria-hidden="true">↗</span></a>
            </div>
        </div>
        @if(data_get($content, 'intro.stats'))
        <div class="impact-grid">
            @foreach(data_get($content, 'intro.stats', []) as $stat)
                <div><strong>{{ data_get($stat, 'value') }}</strong><span>{{ data_get($stat, 'label') }}</span></div>
            @endforeach
        </div>
        @endif
    </section>

    <section id="capacidades" class="section capabilities-section">
        <div class="section-index"><span>02</span><span>Capacidades</span></div>
        <div class="section-heading split">
            <h2>{!! nl2br(e(data_get($content, 'capabilities.title'))) !!}</h2>
            <p>{{ data_get($content, 'capabilities.description') }}</p>
        </div>
        <div class="capability-list" x-data="{ selected: null }">
            @foreach(data_get($content, 'capabilities.items', []) as $index => $item)
                <article class="capability-item" role="button" tabindex="0"
                    aria-labelledby="capability-title-{{ $index }}"
                    :aria-pressed="selected === {{ $index }}"
                    @click="selected = {{ $index }}"
                    @keydown.enter.prevent="selected = {{ $index }}"
                    @keydown.space.prevent="selected = {{ $index }}"><span class="cap-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><div><h3 id="capability-title-{{ $index }}">{{ data_get($item, 'title') }}</h3><p>{{ data_get($item, 'description') }}</p>@if(data_get($item, 'tags'))<span class="cap-tags">{{ data_get($item, 'tags') }}</span>@endif</div><span class="cap-arrow">↗</span></article>
            @endforeach
        </div>
    </section>

    <section id="equipamiento" class="section equipment-section" aria-labelledby="equipment-title">
        <div class="section-index"><span>03</span><span>Infraestructura</span></div>
        <div class="section-heading split">
            <h2 id="equipment-title">{{ data_get($content, 'equipment.title') }}</h2>
            <p>{{ data_get($content, 'equipment.description') }}</p>
        </div>
        <div class="equipment-grid">
            @foreach(data_get($content, 'equipment.items', []) as $item)
                <article class="equipment-card">
                    <span class="equipment-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ data_get($item, 'title') }}</h3>
                    <p>{{ data_get($item, 'description') }}</p>
                </article>
            @endforeach
        </div>
        <div class="equipment-invitation">
            <p>{{ data_get($content, 'equipment.invitation') }}</p>
            <a href="#contacto">Cuéntanos tu proyecto <span class="direction-icon" aria-hidden="true">↗</span></a>
        </div>
    </section>

    <section id="proyectos" class="projects-section">
        <div class="section-index light"><span>04</span><span>Casos seleccionados</span></div>
        <div class="project-intro"><h2>{!! nl2br(e(data_get($content, 'projects.title'))) !!}</h2><p>{{ data_get($content, 'projects.description') }}</p></div>
        <div class="project-grid">
            @foreach(data_get($content, 'projects.items', []) as $index => $project)
                <article class="project-card {{ ['medical', 'tech', 'academy'][$index] ?? 'medical' }}"><div class="project-visual @if(data_get($project, 'image')) has-image @endif" @if(data_get($project, 'image')) style="background-image:url('{{ asset('storage/'.data_get($project, 'image')) }}')" @endif>@unless(data_get($project, 'image'))<span class="orb {{ ['one', 'two', 'three'][$index] ?? 'one' }}"></span><span class="mesh"></span>@endunless</div><div class="project-meta">@if(data_get($project, 'category') || data_get($project, 'year'))<span>{{ collect([data_get($project, 'category'), data_get($project, 'year')])->filter()->implode(' / ') }}</span>@endif<h3>{{ data_get($project, 'title') }}</h3>@if(data_get($project, 'description'))<p>{{ data_get($project, 'description') }}</p>@endif</div></article>
            @endforeach
        </div>
    </section>

    <section class="section network-section">
        <div class="section-index"><span>05</span><span>Nuestra misión</span></div>
        <div class="network-copy"><h2>{{ data_get($content, 'network.title') }}</h2><p>{{ data_get($content, 'network.description') }}</p></div>
        <div class="network-lines"><span>ACADEMIA</span><i>×</i><span>INDUSTRIA</span><i>×</i><span>COMUNIDAD</span><i>=</i><strong>OPEN LAB</strong></div>
    </section>

    @if(data_get($content, 'news.enabled', false))
    <section class="section news-section">
        <div class="section-index"><span>06</span><span>Actualidad</span></div>
        <div class="section-heading split"><h2>{!! nl2br(e(data_get($content, 'news.title'))) !!}</h2><a href="{{ route('blog.index') }}">Ver todas las publicaciones <span class="direction-icon" aria-hidden="true">↗</span></a></div>
        <div class="news-grid">
            @forelse($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="news-card">
                    <div class="news-image @if(!$post->cover_image) placeholder-{{ $loop->iteration }} @endif" @if($post->cover_image) style="background-image:url('{{ $post->coverUrl() }}')" @endif></div>
                    <span>{{ $post->category }} · {{ $post->published_at?->format('d.m.Y') }}</span>
                    <h3>{{ $post->title }}</h3><p>{{ $post->excerpt }}</p><i>Leer más <span class="direction-icon" aria-hidden="true">↗</span></i>
                </a>
            @empty
                <article class="empty-news"><span>PRÓXIMAMENTE</span><h3>Nuevos proyectos, investigación y aprendizajes del laboratorio.</h3></article>
            @endforelse
        </div>
    </section>

    @endif

    <section id="contacto" class="contact-section">
        <div class="contact-copy"><span class="eyebrow light">{{ data_get($content, 'contact.eyebrow') }}</span><h2>{!! nl2br(e(data_get($content, 'contact.title'))) !!}</h2><p>{{ data_get($content, 'contact.description') }}</p></div>
        <livewire:contact-form />
    </section>
</x-public-layout>
