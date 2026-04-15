@php
    $platform = platform_settings();
    $pageTitle = trim($__env->yieldContent('title')) ?: ($platform->default_meta_title ?: $platform->app_name);
    $metaDescription = trim($__env->yieldContent('meta_description')) ?: ($platform->default_meta_description ?: $platform->app_tagline);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">

    @if ($platform->favicon_path)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $platform->favicon_path) }}">
        <link rel="shortcut icon" href="{{ asset('storage/' . $platform->favicon_path) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $platform->favicon_path) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-slate-100 font-sans antialiased text-slate-900">
    <div class="relative min-h-screen bg-slate-100">
        <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-b from-indigo-50/70 via-white to-transparent"></div>

        @include('layouts.navigation')

        @isset($header)
            <header class="border-b border-slate-200/80 bg-white/80 backdrop-blur-xl">
                <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
