        <div class="project-grid">
            @foreach($projects as $index => $project)
                <article class="project-card {{ ['medical', 'tech', 'academy'][$index % 3] }}">
                    <a href="{{ route('projects.show', $project) }}" class="project-visual @if($project->cover_image) has-image @if($project->title === 'Sensafeet') project-visual-contain @endif @endif" aria-label="{{ $project->title }}">
                        @if($project->cover_image)<img src="{{ asset('storage/'.$project->cover_image) }}" alt="{{ $project->title }}" loading="lazy">@endif
                        @unless($project->cover_image)<span class="orb {{ ['one', 'two', 'three'][$index % 3] }}"></span><span class="mesh"></span>@endunless
                    </a>
                    <div class="project-meta"><h3>{{ $project->title }}</h3>@if($project->subtitle)<p class="project-subtitle">{{ $project->subtitle }}</p>@endif<a class="project-link" href="{{ route('projects.show', $project) }}">Ver el Proyecto</a></div>
                </article>
            @endforeach
        </div>
