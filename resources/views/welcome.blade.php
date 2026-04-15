@php
    $platform = platform_settings();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $platform->default_meta_title ?: $platform->app_name }}</title>
    <meta name="description" content="{{ $platform->default_meta_description ?: $platform->app_tagline }}">

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
                            class="h-9 w-auto max-w-[156px] object-contain transition duration-200 group-hover:opacity-95">
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

                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="inline-flex items-center rounded-2xl bg-slate-950 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            Get Started
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
                <div class="grid items-center gap-14 lg:grid-cols-2">
                    <div class="max-w-2xl">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-indigo-700">
                            <span class="inline-flex h-2 w-2 rounded-full bg-indigo-500"></span>
                            Proposal workflow platform
                        </div>

                        <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                            Create polished proposals and manage delivery with clarity.
                        </h1>

                        <p class="mt-6 max-w-xl text-base leading-8 text-slate-600 sm:text-lg">
                            {{ $platform->app_name }} helps freelancers and agencies build premium proposals, manage
                            pricing, track delivery, and follow up with confidence from one unified workspace.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center rounded-2xl bg-slate-950 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                                Start Free
                            </a>

                            <a href="{{ route('login') }}"
                                class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                Login
                            </a>
                        </div>

                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Build</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">Structured proposals</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Deliver</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">PDF, public links, email flow</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Track</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">Analytics and follow-up alerts</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div
                            class="rounded-[32px] border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-8">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Proposal performance</p>
                                    <h3 class="mt-1 text-xl font-bold tracking-tight text-slate-950">
                                        Premium proposal workflow
                                    </h3>
                                </div>

                                <div
                                    class="rounded-2xl bg-slate-950 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-white">
                                    Live
                                </div>
                            </div>

                            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                                    <p class="text-sm font-medium text-slate-500">Accepted Revenue</p>
                                    <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">$12,480</p>
                                    <p class="mt-2 text-sm text-slate-500">Commercial visibility at a glance</p>
                                </div>

                                <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                                    <p class="text-sm font-medium text-slate-500">Pipeline Value</p>
                                    <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">$8,960</p>
                                    <p class="mt-2 text-sm text-slate-500">Track active work still in motion</p>
                                </div>
                            </div>

                            <div class="mt-6 rounded-[24px] border border-slate-200 p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Viewed but Pending</p>
                                        <p class="mt-1 text-sm text-slate-500">Strong follow-up opportunities</p>
                                    </div>

                                    <span
                                        class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        3 alerts
                                    </span>
                                </div>

                                <div class="mt-5 space-y-3">
                                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                        <p class="text-sm font-semibold text-slate-900">Website Redesign Proposal</p>
                                        <p class="mt-1 text-xs text-slate-500">Viewed 2 days ago • Pending decision</p>
                                    </div>

                                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                        <p class="text-sm font-semibold text-slate-900">Mobile App Discovery Phase</p>
                                        <p class="mt-1 text-xs text-slate-500">Reminder scheduled • Follow-up due soon
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="absolute -bottom-6 -left-6 hidden w-44 rounded-[24px] border border-slate-200 bg-white p-4 shadow-lg shadow-slate-200/60 lg:block">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Delivery</p>
                            <p class="mt-2 text-sm font-semibold text-slate-900">PDF + Public Link + Email Draft</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
