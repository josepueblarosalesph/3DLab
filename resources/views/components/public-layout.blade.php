@props(['title' => null, 'siteContent' => null])
<x-layouts.app :title="$title" :site-content="$siteContent">{{ $slot }}</x-layouts.app>
