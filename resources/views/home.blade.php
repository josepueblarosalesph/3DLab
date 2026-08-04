<x-public-layout>
    <section class="hero">
        <video autoplay muted loop playsinline preload="auto" aria-hidden="true">
            <source src="https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260715_090628_7052d8a6-a094-4341-a4a2-ad58493a67a9.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-topline"><span>Hub de innovación tecnológica & I+D</span><span>33.4° S · 70.6° W</span></div>
        <div class="hero-copy">
            <h1>Prototipamos<br>el futuro.</h1>
            <p>Transformamos ideas complejas en soluciones tecnológicas con impacto real, conectando academia, investigación, industria y salud.</p>
            <div class="hero-actions"><a href="#capacidades">Explora capacidades ↓</a><a href="#contacto">Inicia un proyecto ↗</a></div>
        </div>
        <div class="hero-index"><span>OPEN / 01</span><span>Diseñar · Fabricar · Validar</span></div>
    </section>

    <section id="acerca" class="section intro-section">
        <div class="section-index"><span>01</span><span>Qué somos</span></div>
        <div class="intro-main">
            <span class="eyebrow">Un ecosistema de desarrollo</span>
            <h2>Más que un laboratorio: un espacio abierto para convertir conocimiento en soluciones.</h2>
            <p>No solo fabricamos piezas. Articulamos talento, tecnología y metodologías avanzadas dentro de un ecosistema universitario y clínico que acelera la transferencia tecnológica.</p>
        </div>
        <div class="impact-grid">
            <div><strong>+120</strong><span>Prototipos y soluciones desarrolladas</span></div>
            <div><strong>03</strong><span>Líneas estratégicas: academia, industria y salud</span></div>
            <div><strong>100%</strong><span>Conectados con redes de investigación y transferencia</span></div>
        </div>
    </section>

    <section id="capacidades" class="section capabilities-section">
        <div class="section-index"><span>02</span><span>Capacidades</span></div>
        <div class="section-heading split">
            <h2>Tecnología aplicada<br>a desafíos reales.</h2>
            <p>Acompañamos desde la pregunta inicial hasta el prototipo validado, combinando infraestructura avanzada y conocimiento multidisciplinario.</p>
        </div>
        <div class="capability-list">
            <article><span class="cap-number">01</span><div><h3>Fabricación digital<br>& prototipado</h3><p>Impresión 3D avanzada, escaneo, corte y manufactura para acelerar procesos de investigación y desarrollo.</p><span class="cap-tags">FDM · SLA · SLS · CNC</span></div><span class="cap-arrow">↗</span></article>
            <article><span class="cap-number">02</span><div><h3>I+D para startups<br>& empresas</h3><p>Diseño, validación y escalamiento de productos para emprendimientos científico-tecnológicos y equipos de innovación.</p><span class="cap-tags">DISEÑO · ITERACIÓN · VALIDACIÓN</span></div><span class="cap-arrow">↗</span></article>
            <article class="featured"><span class="cap-number">03</span><div><span class="focus-label">Foco estratégico</span><h3>Ingeniería &<br>prototipado médico</h3><p>Modelos anatómicos, fantomas, simuladores y dispositivos desarrollados junto a equipos clínicos.</p><span class="cap-tags">SALUD · SIMULACIÓN · PRECISIÓN</span></div><span class="cap-arrow">↗</span></article>
            <article><span class="cap-number">04</span><div><h3>Formación<br>& workshops</h3><p>Talleres prácticos y metodologías de diseño integradas a asignaturas, equipos y comunidades.</p><span class="cap-tags">MAKER · DESIGN THINKING · STEAM</span></div><span class="cap-arrow">↗</span></article>
        </div>
    </section>

    <section id="proyectos" class="projects-section">
        <div class="section-index light"><span>03</span><span>Casos seleccionados</span></div>
        <div class="project-intro"><h2>Cuando las disciplinas<br>se encuentran.</h2><p>Proyectos que muestran cómo la colaboración multidisciplinaria se convierte en innovación aplicada.</p></div>
        <div class="project-grid">
            <article class="project-card medical"><div class="project-visual"><span class="orb one"></span><span class="mesh"></span></div><div class="project-meta"><span>Salud / 2026</span><h3>Simulador anatómico de alta fidelidad</h3><p>Planificación quirúrgica y validación clínica conjunta.</p></div></article>
            <article class="project-card tech"><div class="project-visual"><span class="orb two"></span><span class="mesh"></span></div><div class="project-meta"><span>Tecnología / 2026</span><h3>Dispositivo IoT para monitoreo industrial</h3><p>Del concepto al primer lote funcional.</p></div></article>
            <article class="project-card academy"><div class="project-visual"><span class="orb three"></span><span class="mesh"></span></div><div class="project-meta"><span>Academia / 2025</span><h3>Desafío Maker interdisciplinario</h3><p>Estudiantes conectados con problemas reales.</p></div></article>
        </div>
    </section>

    <section class="section network-section">
        <div class="section-index"><span>04</span><span>Red de excelencia</span></div>
        <div class="network-copy"><h2>Conectamos capacidades que por separado no generarían el mismo impacto.</h2><p>Nuestra ventaja está en habitar un ecosistema universitario y clínico robusto, articulando expertises bajo estándares rigurosos de calidad, transparencia y ética.</p></div>
        <div class="network-lines"><span>ACADEMIA</span><i>×</i><span>INDUSTRIA</span><i>×</i><span>SALUD</span><i>=</i><strong>OPEN LAB</strong></div>
    </section>

    <section class="section news-section">
        <div class="section-index"><span>05</span><span>Actualidad</span></div>
        <div class="section-heading split"><h2>Investigación<br>en movimiento.</h2><a href="{{ route('blog.index') }}">Ver todas las publicaciones ↗</a></div>
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
        <div class="contact-copy"><span class="eyebrow light">Inicia una colaboración</span><h2>¿Qué podemos<br>prototipar juntos?</h2><p>Cuéntanos brevemente tu desafío. Nuestro equipo revisará el requerimiento y te contactará para definir el siguiente paso.</p></div>
        <livewire:contact-form />
    </section>
</x-public-layout>
