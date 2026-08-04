<x-public-layout title="Actualidad — Open Lab">
    <section class="page-hero"><span class="eyebrow">Investigación abierta</span><h1>Actualidad<br>& conocimiento.</h1><p>Proyectos, aprendizajes, convocatorias y nuevas capacidades del ecosistema Open Lab.</p></section>
    <section class="section blog-listing">
        <div class="news-grid">
            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="news-card">
                    <div class="news-image @if(!$post->cover_image) placeholder-{{ ($loop->iteration % 3) + 1 }} @endif" @if($post->cover_image) style="background-image:url('{{ $post->coverUrl() }}')" @endif></div>
                    <span>{{ $post->category }} · {{ $post->published_at?->format('d.m.Y') }}</span><h3>{{ $post->title }}</h3><p>{{ $post->excerpt }}</p><i>Leer más ↗</i>
                </a>
            @endforeach
        </div>
        <div class="pagination">{{ $posts->links() }}</div>
    </section>
</x-public-layout>
