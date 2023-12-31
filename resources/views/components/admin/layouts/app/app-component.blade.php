<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ $currentTheme->name }}">
    <head>
        <title>{{ $meta->title }}</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{{ $meta->description }}">
        <meta name="keywords" content="{{ $meta->keywords }}">
        <meta name="robots" content="noindex, nofollow">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="turbo-cache-control" content="no-preview">

        <link rel="canonical" href="{{ $meta->url }}">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/icons/android-chrome-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icons/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('images/icons/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('images/icons/safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="shortcut icon" href="{{ asset('images/icons/favicon.ico') }}">
        <meta name="msapplication-TileColor" content="#2d89ef">
        <meta name="msapplication-config" content="{{ asset('images/icons/browserconfig.xml') }}">
        <meta name="theme-color" content="#ffffff">

        @vite('resources/sass/admin.scss')
        @stack('styles')

        @vite('resources/js/admin.js')   
        @stack('head-scripts')     
    </head>
    <body>
        {{ $slot }}
        
        @livewireScriptConfig 
        @if(config('livewire.wire_navigate') && !config('livewire.back_button_cache'))
        <script>window.addEventListener("popstate", () => window.location.reload() );</script>
        @endif        
    </body>
</html>
