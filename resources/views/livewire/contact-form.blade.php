<div class="contact-form-wrap">
    @if($sent)
        <div class="form-success"><span>✓</span><h3>Recibimos tu mensaje.</h3><p>Gracias por pensar en Open Lab. Te contactaremos pronto.</p><button wire:click="$set('sent', false)">Enviar otro mensaje</button></div>
    @else
        <form wire:submit="submit" class="contact-form">
            <label><span>Nombre *</span><input type="text" wire:model="name" placeholder="Tu nombre">@error('name')<small>{{ $message }}</small>@enderror</label>
            <label><span>Organización</span><input type="text" wire:model="organization" placeholder="Universidad, empresa o institución"></label>
            <label><span>Correo *</span><input type="email" wire:model="email" placeholder="nombre@organizacion.cl">@error('email')<small>{{ $message }}</small>@enderror</label>
            <label><span>Tu rol *</span><select wire:model="role"><option value="">Selecciona una opción</option><option>Investigador/a</option><option>Empresa o startup</option><option>Equipo clínico</option><option>Académico/a</option><option>Estudiante</option></select>@error('role')<small>{{ $message }}</small>@enderror</label>
            <label class="full"><span>Área de colaboración *</span><select wire:model="area"><option value="">Selecciona una capacidad</option><option>Fabricación digital y prototipado</option><option>I+D para startups y empresas</option><option>Ingeniería y prototipado médico</option><option>Formación y workshops</option><option>Otra</option></select>@error('area')<small>{{ $message }}</small>@enderror</label>
            <label class="full"><span>Cuéntanos sobre el desafío *</span><textarea wire:model="message" rows="5" placeholder="Objetivo, contexto y etapa actual del proyecto..."></textarea>@error('message')<small>{{ $message }}</small>@enderror</label>
            <button type="submit" wire:loading.attr="disabled"><span wire:loading.remove>Enviar requerimiento <span class="direction-icon" aria-hidden="true">↗</span></span><span wire:loading>Enviando...</span></button>
        </form>
    @endif
</div>
