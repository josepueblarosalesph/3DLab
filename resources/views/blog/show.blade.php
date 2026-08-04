<x-public-layout :title="$post->title.' — Open Lab'">
    <article class="article-page">
        <header><span>{{ $post->category }} · {{ $post->published_at?->format('d.m.Y') }}</span><h1>{{ $post->title }}</h1><p>{{ $post->excerpt }}</p></header>
        @if($post->cover_image)<div class="article-cover" style="background-image:url('{{ $post->coverUrl() }}')"></div>@endif
        <div class="article-body">{!! $post->body !!}</div>
        <a href="{{ route('blog.index') }}" class="back-link">← Volver a actualidad</a>
    </article>
</x-public-layout>
