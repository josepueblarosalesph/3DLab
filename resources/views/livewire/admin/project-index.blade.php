<div>
    <x-header title="Proyectos" subtitle="Administra los proyectos que aparecen en el inicio." separator>
        <x-slot:actions><x-button label="Nuevo proyecto" icon="o-plus" :link="route('admin.projects.create')" class="openlab-primary" /></x-slot:actions>
    </x-header>
    @if(session('success'))<p role="status" class="mb-5">{{ session('success') }}</p>@endif
    <div class="space-y-4">
        @forelse($projects as $project)
            <article class="border border-black/10 p-5 flex gap-5 items-center">
                @if($project->cover_image)<img src="{{ asset('storage/'.$project->cover_image) }}" alt="" class="w-24 h-20 object-cover">@endif
                <div class="flex-1"><h2 class="font-semibold">{{ $project->title }}</h2>@if($project->subtitle)<p class="text-sm">{{ $project->subtitle }}</p>@endif<p>{{ $project->excerpt() }}</p></div>
                <x-button label="Editar" :link="route('admin.projects.edit', $project)" class="btn-ghost" />
                <a href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener">Ver proyecto</a>
            </article>
        @empty<p>No hay proyectos todavía.</p>@endforelse
    </div>
</div>
