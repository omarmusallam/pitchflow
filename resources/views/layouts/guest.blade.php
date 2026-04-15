@php
    $platform = platform_settings();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $platform->app_name }}</title>
    <meta name="description" content="{{ $platform->app_tagline }}">

    @if ($platform->favicon_path)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $platform->favicon_path) }}">
        <link rel="shortcut icon" href="{{ asset('storage/' . $platform->favicon_path) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $platform->favicon_path) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-slate-100 text-slate-900 antialiased">
    <div class="relative min-h-screen overflow-hidden bg-slate-100">
        <div class="absolute inset-x-0 top-0 -z-10 h-[420px] bg-gradient-to-b from-indigo-50 via-white to-transparent">
        </div>
        <div
            class="absolute left-1/2 top-0 -z-10 h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-indigo-200/20 blur-3xl">
        </div>

        <header class="border-b border-slate-200/80 bg-white/85 backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="group flex items-center gap-3">
                    @if ($platform->logo_path)
                        <img src="{{ asset('storage/' . $platform->logo_path) }}" alt="{{ $platform->app_name }}"
                            class="h-10 w-auto max-w-[220px] object-contain transition duration-200 group-hover:opacity-95">
                    @else
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-500 text-sm font-bold text-white shadow-sm">
                            P
                        </span>
                    @endif

                    @if ($platform->show_platform_branding)
                        <div class="leading-tight">
                            <div class="text-[15px] font-semibold tracking-tight text-slate-950">
                                {{ $platform->app_name }}
                            </div>
                            <div class="text-[11px] font-medium text-slate-500">
                                {{ $platform->app_tagline ?: 'Proposal Workspace' }}
                            </div>
                        </div>
                    @endif
                </a>

                <a href="{{ route('login') }}"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Login
                </a>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
