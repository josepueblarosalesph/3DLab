<x-public-layout :site-content="$content">
    <section class="hero">
        <div class="hero-art @if(data_get($content, 'hero.image')) has-custom-image @endif" @if(data_get($content, 'hero.image')) style="background-image:url('{{ asset('storage/'.data_get($content, 'hero.image')) }}')" @endif aria-hidden="true"></div>
        <div class="hero-grid" aria-hidden="true"></div>
        <div class="hero-scan" aria-hidden="true"></div>
        <div class="hero-coordinates" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
        <div class="hero-overlay"></div>
        <div class="hero-topline"><span>{{ data_get($content, 'hero.eyebrow') }}</span><span>33.4° S · 70.6° W</span></div>
        <div class="hero-copy">
            <h1>{!! nl2br(e(data_get($content, 'hero.title'))) !!}</h1>
            <p>{{ data_get($content, 'hero.description') }}</p>
            <div class="hero-actions"><a href="#capacidades">{{ data_get($content, 'hero.primary_cta') }} ↓</a><a href="#contacto">{{ data_get($content, 'hero.secondary_cta') }} ↗</a></div>
        </div>
        <div class="hero-index"><span>OPEN / 01</span><span>{{ data_get($content, 'hero.strapline') }}</span></div>
    </section>

    <section id="acerca" class="section intro-section">
        <div class="section-index"><span>01</span><span>Qué somos</span></div>
        <div class="intro-main">
            <span class="eyebrow">{{ data_get($content, 'intro.eyebrow') }}</span>
            <h2>{{ data_get($content, 'intro.title') }}</h2>
            <p>{{ data_get($content, 'intro.description') }}</p>
        </div>
        <div class="impact-grid">
            @foreach(data_get($content, 'intro.stats', []) as $stat)
                <div><strong>{{ data_get($stat, 'value') }}</strong><span>{{ data_get($stat, 'label') }}</span></div>
            @endforeach
        </div>
    </section>

    <section id="capacidades" class="section capabilities-section">
        <div class="section-index"><span>02</span><span>Capacidades</span></div>
        <div class="section-heading split">
            <h2>{!! nl2br(e(data_get($content, 'capabilities.title'))) !!}</h2>
            <p>{{ data_get($content, 'capabilities.description') }}</p>
        </div>
        <div class="capability-list">
            @foreach(data_get($content, 'capabilities.items', []) as $index => $item)
                <article @class(['featured' => $index === 2])><span class="cap-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><div>@if($index === 2)<span class="focus-label">Foco estratégico</span>@endif<h3>{{ data_get($item, 'title') }}</h3><p>{{ data_get($item, 'description') }}</p><span class="cap-tags">{{ data_get($item, 'tags') }}</span></div><span class="cap-arrow">↗</span></article>
            @endforeach
        </div>
    </section>

    <section id="proyectos" class="projects-section">
        <div class="section-index light"><span>03</span><span>Casos seleccionados</span></div>
        <div class="project-intro"><h2>{!! nl2br(e(data_get($content, 'projects.title'))) !!}</h2><p>{{ data_get($content, 'projects.description') }}</p></div>
        <div class="project-grid">
            @foreach(data_get($content, 'projects.items', []) as $index => $project)
                <article class="project-card {{ ['medical', 'tech', 'academy'][$index] ?? 'medical' }}"><div class="project-visual @if(data_get($project, 'image')) has-image @endif" @if(data_get($project, 'image')) style="background-image:url('{{ asset('storage/'.data_get($project, 'image')) }}')" @endif>@unless(data_get($project, 'image'))<span class="orb {{ ['one', 'two', 'three'][$index] ?? 'one' }}"></span><span class="mesh"></span>@endunless</div><div class="project-meta"><span>{{ data_get($project, 'category') }} / {{ data_get($project, 'year') }}</span><h3>{{ data_get($project, 'title') }}</h3><p>{{ data_get($project, 'description') }}</p></div></article>
            @endforeach
        </div>
    </section>

    <section class="section network-section">
        <div class="section-index"><span>04</span><span>Red de excelencia</span></div>
        <div class="network-copy"><h2>{{ data_get($content, 'network.title') }}</h2><p>{{ data_get($content, 'network.description') }}</p></div>
        <div class="network-lines"><span>ACADEMIA</span><i>×</i><span>INDUSTRIA</span><i>×</i><span>SALUD</span><i>=</i><strong>OPEN LAB</strong></div>
    </section>

    <section class="section news-section">
        <div class="section-index"><span>05</span><span>Actualidad</span></div>
        <div class="section-heading split"><h2>{!! nl2br(e(data_get($content, 'news.title'))) !!}</h2><a href="{{ route('blog.index') }}">Ver todas las publicaciones ↗</a></div>
        <div class="news-grid">
            @forelse($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="news-card">
                    <div class="news-image @if(!$post->cover_image) placeholder-{{ $loop->iteration }} @endif" @if($post->cover_image) style="background-image:url('{{ $post->coverUrl() }}')" @endif></div>
                    <span>{{ $post->category }} · {{ $post->published_at?->format('d.m.Y') }}</span>
                    <h3>{{ $post->title }}</h3><p>{{ $post->excerpt }}</p><i>Leer más ↗</i>
                </a>
            @empty
                <article class="empty-news"><span>PRÓXIMAMENTE</span><h3>Nuevos proyectos, investigación y aprendizajes del laboratorio.</h3></article>
            @endforelse
        </div>
    </section>

    <section id="contacto" class="contact-section">
        <div class="contact-copy"><span class="eyebrow light">{{ data_get($content, 'contact.eyebrow') }}</span><h2>{!! nl2br(e(data_get($content, 'contact.title'))) !!}</h2><p>{{ data_get($content, 'contact.description') }}</p></div>
        <livewire:contact-form />
    </section>
</x-public-layout>
