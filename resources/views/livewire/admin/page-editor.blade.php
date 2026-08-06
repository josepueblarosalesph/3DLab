<div class="site-editor" x-data="{ preview: true }">
    <div class="admin-heading editor-heading">
        <div>
            <span>Contenido del sitio</span>
            <h1>Editar portada.</h1>
            <p>Modifica textos e imágenes y revisa el resultado antes de publicarlo.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-button label="Ver sitio" icon="o-arrow-top-right-on-square" :link="route('home')" external />
            <x-button label="Publicar cambios" icon="o-check" wire:click="save" class="openlab-primary" spinner="save" />
        </div>
    </div>

    @if(session('success'))
        <div class="editor-success" role="status"><x-icon name="o-check-circle" class="w-5 h-5" />{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="editor-errors" role="alert"><strong>Revisa los campos marcados.</strong><span>{{ $errors->first() }}</span></div>
    @endif

    <div class="editor-toolbar">
        <p><span class="editor-status-dot"></span>Los cambios se publican únicamente al presionar “Publicar cambios”.</p>
        <button type="button" class="editor-preview-toggle" @click="preview = !preview" x-text="preview ? 'Ocultar vista previa' : 'Mostrar vista previa'"></button>
    </div>

    <div class="editor-layout" :class="preview ? '' : 'preview-hidden'">
        <form wire:submit="save" class="editor-form">
            <details class="editor-section" wire:key="editor-section-hero" wire:ignore.self open>
                <summary><span><i>01</i>Portada principal</span><small>Mensaje e imagen de entrada</small></summary>
                <div class="editor-section-body">
                    <label class="editor-field"><span>Etiqueta superior</span><input wire:model.live.debounce.350ms="content.hero.eyebrow" maxlength="120"></label>
                    <label class="editor-field"><span>Título <small>Usa Enter para separar líneas</small></span><textarea wire:model.live.debounce.350ms="content.hero.title" rows="3" maxlength="120"></textarea></label>
                    <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.hero.description" rows="4" maxlength="360"></textarea></label>
                    <div class="editor-field-grid">
                        <label class="editor-field"><span>Botón capacidades</span><input wire:model.live.debounce.350ms="content.hero.primary_cta" maxlength="60"></label>
                        <label class="editor-field"><span>Botón contacto</span><input wire:model.live.debounce.350ms="content.hero.secondary_cta" maxlength="60"></label>
                    </div>
                    <label class="editor-field"><span>Frase inferior</span><input wire:model.live.debounce.350ms="content.hero.strapline" maxlength="120"></label>
                    <div class="editor-image-field">
                        <div><strong>Imagen principal</strong><p>JPG, PNG o WebP, máximo 8 MB. Si no cargas una imagen se usará la gráfica original.</p></div>
                        @php($heroPreview = $heroImage ? $heroImage->temporaryUrl() : (data_get($content, 'hero.image') ? asset('storage/'.data_get($content, 'hero.image')) : asset('og.png')))
                        <img src="{{ $heroPreview }}" alt="Vista previa de portada">
                        <x-file wire:model="heroImage" accept="image/png,image/jpeg,image/webp" />
                        <div wire:loading wire:target="heroImage" class="editor-uploading">Procesando imagen…</div>
                        @if($heroImage || data_get($content, 'hero.image'))
                            <button type="button" wire:click="removeImage('hero.image')" class="editor-remove">Usar gráfica original</button>
                        @endif
                    </div>
                </div>
            </details>

            <details class="editor-section" wire:key="editor-section-intro" wire:ignore.self>
                <summary><span><i>02</i>Qué somos</span><small>Presentación e indicadores</small></summary>
                <div class="editor-section-body">
                    <label class="editor-field"><span>Etiqueta</span><input wire:model.live.debounce.350ms="content.intro.eyebrow"></label>
                    <label class="editor-field"><span>Título</span><textarea wire:model.live.debounce.350ms="content.intro.title" rows="4"></textarea></label>
                    <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.intro.description" rows="4"></textarea></label>
                    <h3 class="editor-subtitle">Indicadores</h3>
                    @foreach(data_get($content, 'intro.stats', []) as $index => $stat)
                        <div class="editor-repeat" wire:key="stat-{{ $index }}">
                            <b>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</b>
                            <div class="editor-field-grid stat-grid">
                                <label class="editor-field"><span>Valor</span><input wire:model.live.debounce.350ms="content.intro.stats.{{ $index }}.value"></label>
                                <label class="editor-field"><span>Descripción</span><input wire:model.live.debounce.350ms="content.intro.stats.{{ $index }}.label"></label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </details>

            <details class="editor-section" wire:key="editor-section-capabilities" wire:ignore.self>
                <summary><span><i>03</i>Capacidades</span><small>Servicios del laboratorio</small></summary>
                <div class="editor-section-body">
                    <label class="editor-field"><span>Título</span><textarea wire:model.live.debounce.350ms="content.capabilities.title" rows="3"></textarea></label>
                    <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.capabilities.description" rows="3"></textarea></label>
                    @foreach(data_get($content, 'capabilities.items', []) as $index => $item)
                        <div class="editor-card" wire:key="capability-{{ $index }}">
                            <h3>Capacidad {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h3>
                            <label class="editor-field"><span>Nombre</span><input wire:model.live.debounce.350ms="content.capabilities.items.{{ $index }}.title"></label>
                            <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.capabilities.items.{{ $index }}.description" rows="3"></textarea></label>
                            <label class="editor-field"><span>Tecnologías / etiquetas</span><input wire:model.live.debounce.350ms="content.capabilities.items.{{ $index }}.tags"></label>
                        </div>
                    @endforeach
                </div>
            </details>

            <details class="editor-section" wire:key="editor-section-projects" wire:ignore.self>
                <summary><span><i>04</i>Proyectos</span><small>Casos e imágenes destacadas</small></summary>
                <div class="editor-section-body">
                    <label class="editor-field"><span>Título</span><textarea wire:model.live.debounce.350ms="content.projects.title" rows="3"></textarea></label>
                    <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.projects.description" rows="3"></textarea></label>
                    @foreach(data_get($content, 'projects.items', []) as $index => $project)
                        <div class="editor-card" wire:key="project-{{ $index }}">
                            <h3>Proyecto {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h3>
                            <div class="editor-field-grid">
                                <label class="editor-field"><span>Categoría</span><input wire:model.live.debounce.350ms="content.projects.items.{{ $index }}.category"></label>
                                <label class="editor-field"><span>Año</span><input wire:model.live.debounce.350ms="content.projects.items.{{ $index }}.year"></label>
                            </div>
                            <label class="editor-field"><span>Título</span><input wire:model.live.debounce.350ms="content.projects.items.{{ $index }}.title"></label>
                            <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.projects.items.{{ $index }}.description" rows="2"></textarea></label>
                            @php($projectImage = $projectImages[$index] ?? null)
                            @php($projectPreview = $projectImage ? $projectImage->temporaryUrl() : (data_get($content, "projects.items.$index.image") ? asset('storage/'.data_get($content, "projects.items.$index.image")) : null))
                            @if($projectPreview)<img src="{{ $projectPreview }}" class="editor-project-image" alt="Vista previa del proyecto {{ $index + 1 }}">@endif
                            <x-file wire:model="projectImages.{{ $index }}" accept="image/png,image/jpeg,image/webp" />
                            <div wire:loading wire:target="projectImages.{{ $index }}" class="editor-uploading">Procesando imagen…</div>
                            @if($projectImage || data_get($content, "projects.items.$index.image"))
                                <button type="button" wire:click="removeImage('projects.items.{{ $index }}.image')" class="editor-remove">Quitar imagen</button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </details>

            <details class="editor-section" wire:key="editor-section-other" wire:ignore.self>
                <summary><span><i>05</i>Otros bloques</span><small>Red, actualidad y contacto</small></summary>
                <div class="editor-section-body">
                    <h3 class="editor-subtitle">Red de excelencia</h3>
                    <label class="editor-field"><span>Título</span><textarea wire:model.live.debounce.350ms="content.network.title" rows="3"></textarea></label>
                    <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.network.description" rows="3"></textarea></label>
                    <h3 class="editor-subtitle">Actualidad</h3>
                    <label class="editor-field"><span>Título</span><textarea wire:model.live.debounce.350ms="content.news.title" rows="2"></textarea></label>
                    <h3 class="editor-subtitle">Contacto</h3>
                    <label class="editor-field"><span>Etiqueta</span><input wire:model.live.debounce.350ms="content.contact.eyebrow"></label>
                    <label class="editor-field"><span>Título</span><textarea wire:model.live.debounce.350ms="content.contact.title" rows="3"></textarea></label>
                    <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.contact.description" rows="3"></textarea></label>
                </div>
            </details>

            <details class="editor-section" wire:key="editor-section-footer" wire:ignore.self>
                <summary><span><i>06</i>Pie de página</span><small>Mensaje y datos de contacto</small></summary>
                <div class="editor-section-body">
                    <label class="editor-field"><span>Etiqueta</span><input wire:model.live.debounce.350ms="content.footer.eyebrow"></label>
                    <label class="editor-field"><span>Título</span><textarea wire:model.live.debounce.350ms="content.footer.title" rows="3"></textarea></label>
                    <label class="editor-field"><span>Descripción</span><textarea wire:model.live.debounce.350ms="content.footer.description" rows="3"></textarea></label>
                    <div class="editor-field-grid">
                        <label class="editor-field"><span>Correo</span><input type="email" wire:model.live.debounce.350ms="content.footer.email"></label>
                        <label class="editor-field"><span>Ubicación</span><input wire:model.live.debounce.350ms="content.footer.location"></label>
                    </div>
                    <label class="editor-field"><span>URL de Instagram</span><input wire:model="content.footer.instagram_url" placeholder="https://instagram.com/..."></label>
                    <label class="editor-field"><span>URL de LinkedIn</span><input wire:model="content.footer.linkedin_url" placeholder="https://linkedin.com/..."></label>
                </div>
            </details>

            <div class="editor-submit">
                <button type="button" wire:click="restoreDefaults" wire:confirm="¿Restaurar todos los textos y gráficos originales? Los cambios se aplicarán al publicar." class="editor-reset">Restaurar contenido original</button>
                <x-button type="submit" label="Publicar cambios" icon="o-check" class="openlab-primary" spinner="save" />
            </div>
        </form>

        <aside class="editor-preview" x-show="preview" x-transition.opacity>
            <div class="preview-browser">
                <div class="preview-browser-bar"><i></i><i></i><i></i><span>openlab.cl</span></div>
                <div class="preview-page">
                    <div class="preview-hero" @if($heroPreview) style="background-image:linear-gradient(90deg,rgba(9,10,8,.97),rgba(9,10,8,.18)),url('{{ $heroPreview }}')" @endif>
                        <b>OPEN LAB <em>/</em></b>
                        <span>{{ data_get($content, 'hero.eyebrow') }}</span>
                        <h2>{!! nl2br(e(data_get($content, 'hero.title'))) !!}</h2>
                        <p>{{ data_get($content, 'hero.description') }}</p>
                        <button>{{ data_get($content, 'hero.secondary_cta') }} ↗</button>
                    </div>
                    <div class="preview-intro"><small>{{ data_get($content, 'intro.eyebrow') }}</small><h3>{{ data_get($content, 'intro.title') }}</h3><p>{{ data_get($content, 'intro.description') }}</p></div>
                    <div class="preview-capabilities"><small>CAPACIDADES</small><h3>{!! nl2br(e(data_get($content, 'capabilities.title'))) !!}</h3>@foreach(data_get($content, 'capabilities.items', []) as $index => $item)<div><i>0{{ $index + 1 }}</i><b>{{ data_get($item, 'title') }}</b><span>↗</span></div>@endforeach</div>
                    <div class="preview-projects"><small>CASOS SELECCIONADOS</small><h3>{!! nl2br(e(data_get($content, 'projects.title'))) !!}</h3><div>@foreach(data_get($content, 'projects.items', []) as $index => $project)<article @if(($projectImages[$index] ?? null) || data_get($project, 'image')) style="background-image:linear-gradient(0deg,rgba(0,0,0,.75),transparent),url('{{ ($projectImages[$index] ?? null)?->temporaryUrl() ?? asset('storage/'.data_get($project, 'image')) }}')" @endif><span>{{ data_get($project, 'category') }}</span><b>{{ data_get($project, 'title') }}</b></article>@endforeach</div></div>
                    <div class="preview-contact"><small>{{ data_get($content, 'contact.eyebrow') }}</small><h3>{!! nl2br(e(data_get($content, 'contact.title'))) !!}</h3></div>
                </div>
            </div>
            <p class="preview-note">Vista previa orientativa · El sitio publicado mantiene su adaptación a móvil y escritorio.</p>
        </aside>
    </div>
</div>
