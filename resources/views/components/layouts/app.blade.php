<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Open Lab — Innovación, tecnología y prototipado' }}</title>
    <meta name="description" content="Open Lab conecta academia, investigación e industria para diseñar, prototipar y escalar soluciones tecnológicas con impacto real.">
    <meta property="og:title" content="Open Lab — Prototipamos el futuro">
    <meta property="og:description" content="Hub de innovación tecnológica, fabricación digital e I+D.">
    <meta property="og:image" content="{{ asset('og.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ asset('og.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="public-site">
    <header class="site-header" x-data="{ open: false }">
        <a href="{{ route('home') }}" class="brand" aria-label="Open Lab, inicio">
            <span class="brand-symbol" aria-hidden="true"><i></i><i></i></span>
            <span>OPEN LAB</span>
        </a>
        <nav class="desktop-nav" aria-label="Navegación principal">
            <a href="{{ route('home') }}#acerca">Nosotros</a>
            <a href="{{ route('home') }}#capacidades">Capacidades</a>
            <a href="{{ route('home') }}#proyectos">Proyectos</a>
            <a href="{{ route('blog.index') }}">Actualidad</a>
        </nav>
        <a href="{{ route('home') }}#contacto" class="nav-cta">Inicia un proyecto <span>↗</span></a>
        <button class="menu-toggle" @click="open = !open" :aria-expanded="open" aria-label="Abrir menú">Menú</button>
        <div class="mobile-nav" x-show="open" x-transition @click.outside="open = false">
            <a href="{{ route('home') }}#acerca">Nosotros</a>
            <a href="{{ route('home') }}#capacidades">Capacidades</a>
            <a href="{{ route('home') }}#proyectos">Proyectos</a>
            <a href="{{ route('blog.index') }}">Actualidad</a>
            <a href="{{ route('home') }}#contacto">Inicia un proyecto ↗</a>
        </div>
    </header>

    <main>{{ $slot }}</main>

    <footer class="site-footer">
        <div class="footer-lead">
            <span class="eyebrow light">Hagamos algo relevante</span>
            <h2>Ideas abiertas.<br>Impacto real.</h2>
            <a href="{{ route('home') }}#contacto" class="circle-link" aria-label="Ir a contacto">↗</a>
        </div>
        <div class="footer-grid">
            <div><strong>Open Lab</strong><p>Hub de innovación tecnológica,<br>fabricación digital e I+D.</p></div>
            <div><span>Contacto</span><a href="mailto:contacto@openlab.cl">contacto@openlab.cl</a><p>Santiago, Chile</p></div>
            <div><span>Explora</span><a href="{{ route('blog.index') }}">Actualidad</a><a href="{{ route('login') }}">Acceso equipo</a></div>
            <div><span>Síguenos</span><a href="#">Instagram ↗</a><a href="#">LinkedIn ↗</a></div>
        </div>
        <div class="footer-bottom"><span>© {{ date('Y') }} Open Lab</span><span>Academia × Industria × Salud</span></div>
    </footer>
    @livewireScripts
</body>
</html>
