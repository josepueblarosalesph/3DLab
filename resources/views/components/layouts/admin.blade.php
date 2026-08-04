<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Administración' }} — Open Lab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Space+Grotesk:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-[#f3f3ef] text-[#161616] font-sans">
    <x-nav sticky class="border-b border-black/10 bg-white lg:hidden">
        <x-slot:brand><span class="font-display font-bold tracking-tight">OPEN LAB / ADMIN</span></x-slot:brand>
        <x-slot:actions><label for="admin-drawer"><x-icon name="o-bars-3" class="cursor-pointer" /></label></x-slot:actions>
    </x-nav>
    <x-main full-width>
        <x-slot:sidebar drawer="admin-drawer" collapsible class="admin-sidebar bg-[#161616] text-white border-r-0">
            <div class="p-5 mb-4"><a href="{{ route('admin.dashboard') }}" class="font-display text-xl font-bold tracking-tight">OPEN LAB <span class="text-[#ff5c35]">/</span></a><p class="text-xs text-white/45 mt-1">Gestión de contenidos</p></div>
            <x-menu activate-by-route>
                <x-menu-item title="Resumen" icon="o-squares-2x2" :link="route('admin.dashboard')" />
                <x-menu-item title="Publicaciones" icon="o-newspaper" :link="route('admin.posts.index')" />
                <x-menu-item title="Nueva publicación" icon="o-plus-circle" :link="route('admin.posts.create')" />
                <x-menu-item title="Consultas" icon="o-inbox" :link="route('admin.inquiries.index')" />
                <x-menu-separator />
                <x-menu-item title="Ver sitio" icon="o-arrow-top-right-on-square" :link="route('home')" external />
            </x-menu>
            <div class="mt-auto p-4 border-t border-white/10">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p><p class="text-xs text-white/40 mb-3">{{ auth()->user()->email }}</p>
                <form method="POST" action="{{ route('admin.logout') }}">@csrf<x-button type="submit" label="Cerrar sesión" icon="o-arrow-left-start-on-rectangle" class="btn-sm btn-ghost text-white/60" /></form>
            </div>
        </x-slot:sidebar>
        <x-slot:content><div class="admin-content max-w-7xl mx-auto px-4 py-6 lg:px-10 lg:py-10">{{ $slot }}</div></x-slot:content>
    </x-main>
    <x-toast />
    @livewireScripts
</body>
</html>
