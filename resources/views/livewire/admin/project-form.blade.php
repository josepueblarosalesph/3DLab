<div>
    <x-header :title="$project ? 'Editar proyecto' : 'Nuevo proyecto'" separator><x-slot:actions><x-button label="Volver" :link="route('admin.projects.index')" class="btn-ghost" /></x-slot:actions></x-header>
    <form wire:submit="save" class="space-y-6">
        <div class="border border-black/10 bg-white p-6 space-y-5">
            <x-input label="Título" wire:model.live.debounce.500ms="title" required />
            <x-input label="Subtítulo" wire:model="subtitle" hint="Opcional. Se muestra debajo del título." />
            <x-input label="URL amigable" wire:model="slug" prefix="/proyectos/" required />
            <x-textarea label="Descripción completa" wire:model="description" rows="12" hint="La descripción se muestra completa dentro de la ficha del proyecto." required />
        </div>
        <div class="border border-black/10 bg-white p-6 space-y-4">
            <h2 class="font-semibold">Imagen destacada</h2>
            @if($cover)<img src="{{ $cover->temporaryUrl() }}" alt="Previsualización" class="w-64 aspect-video object-cover">@elseif($existingCover)<img src="{{ asset('storage/'.$existingCover) }}" alt="Imagen actual" class="w-64 aspect-video object-cover">@endif
            <x-file label="Seleccionar imagen" wire:model="cover" accept="image/*" hint="Máximo 8 MB." />
            @if($cover || $existingCover)<x-button label="Quitar imagen destacada" wire:click="removeCover" class="btn-ghost" />@endif
        </div>
        <div class="border border-black/10 bg-white p-6 space-y-4">
            <h2 class="font-semibold">Galería de fotos</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($gallery as $index => $photo)<div wire:key="gallery-{{ $index }}-{{ md5($photo) }}"><img src="{{ asset('storage/'.$photo) }}" alt="Foto {{ $index + 1 }}" class="aspect-video w-full object-cover"><x-button label="Quitar foto" wire:click="removePhoto({{ $index }})" class="btn-ghost btn-sm" /></div>@endforeach
                @foreach($photos as $photo)<img src="{{ $photo->temporaryUrl() }}" alt="Nueva foto" class="aspect-video w-full object-cover">@endforeach
            </div>
            <x-file label="Agregar fotos" wire:model="photos" multiple accept="image/*" hint="Hasta 30 fotos por carga. Máximo 8 MB por foto." />
            @error('photos.*')<p class="text-error">{{ $message }}</p>@enderror
        </div>
        <p wire:loading wire:target="cover,photos">Subiendo imágenes…</p>
        <x-button type="submit" label="Guardar proyecto" class="openlab-primary" spinner="save" wire:loading.attr="disabled" wire:target="cover,photos,save" />
    </form>
</div>
