@php
    $platform = platform_settings();
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-[76px] items-center justify-between gap-6">
            <div class="flex min-w-0 items-center gap-8">
                <a href="{{ route('dashboard') }}" class="group flex min-w-0 shrink-0 items-center gap-3">
                    <div class="flex h-11 items-center">
                        @if ($platform->logo_path)
                            <img
                                src="{{ asset('storage/' . $platform->logo_path) }}"
                                alt="{{ $platform->app_name }}"
                                class="h-11 md:h-12 w-auto max-w-[220px] object-contain">
                        @else
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-500 text-sm font-bold text-white shadow-sm">
                                P
                            </span>
                        @endif
                    </div>

                    @if ($platform->show_platform_branding)
                        <div class="min-w-0 leading-tight">
                            <div class="truncate text-[15px] font-semibold tracking-tight text-slate-900">
                                {{ $platform->app_name }}
                            </div>
                            <div class="truncate text-[11px] font-medium text-slate-500">
                                {{ $platform->app_tagline ?: 'Proposal Workspace' }}
                            </div>
                        </div>
                    @endif
                </a>

                <div class="hidden items-center gap-1 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')">
                        {{ __('Clients') }}
                    </x-nav-link>

                    <x-nav-link :href="route('proposals.index')" :active="request()->routeIs('proposals.*')">
                        {{ __('Proposals') }}
                    </x-nav-link>

                    <x-nav-link :href="route('workspace-settings.edit')" :active="request()->routeIs('workspace-settings.*')">
                        {{ __('Settings') }}
                    </x-nav-link>

                    <x-nav-link :href="route('platform-settings.edit')" :active="request()->routeIs('platform-settings.*')">
                        {{ __('Platform') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden min-w-0 items-center gap-4 lg:flex">
                <form action="{{ route('search.index') }}" method="GET" class="hidden xl:block">
                    <div class="relative">
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search proposals or clients..."
                            class="w-72 rounded-2xl border border-slate-200 bg-white/90 py-2.5 pl-4 pr-10 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-300 focus:ring-4 focus:ring-indigo-100">

                        <button
                            type="submit"
                            class="absolute inset-y-0 right-2 inline-flex items-center rounded-xl px-2 text-slate-400 transition hover:text-slate-600"
                            aria-label="Search">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>
                </form>

                <x-dropdown align="right" width="60">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/90 px-3.5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-white">
                            <span
                                class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-100 font-semibold text-slate-700">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>

                            <div class="text-left leading-tight">
                                <div class="max-w-[160px] truncate text-sm font-semibold text-slate-800">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="max-w-[180px] truncate text-xs text-slate-500">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>

                            <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 0 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3">
                            <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                            <div class="mt-1 text-xs text-slate-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="border-t border-slate-100"></div>

                        <x-dropdown-link :href="route('search.index')">
                            {{ __('Global Search') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center lg:hidden">
                <button
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white p-2.5 text-slate-500 shadow-sm transition hover:bg-slate-50 hover:text-slate-700">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path
                            :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-slate-200 bg-white lg:hidden">
        <div class="space-y-4 px-4 py-5 sm:px-6">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4">
                <div class="flex items-center gap-3">
                    @if ($platform->logo_path)
                        <img
                            src="{{ asset('storage/' . $platform->logo_path) }}"
                            alt="{{ $platform->app_name }}"
                            class="h-8 w-auto max-w-[120px] object-contain">
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-500 text-sm font-bold text-white shadow-sm">
                            P
                        </span>
                    @endif

                    @if ($platform->show_platform_branding)
                        <div class="leading-tight">
                            <div class="text-sm font-semibold text-slate-900">
                                {{ $platform->app_name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $platform->app_tagline ?: 'Proposal Workspace' }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('search.index') }}" method="GET">
                <label for="mobile-global-search" class="mb-2 block text-sm font-semibold text-slate-700">
                    Search
                </label>

                <div class="relative">
                    <input
                        type="text"
                        name="q"
                        id="mobile-global-search"
                        value="{{ request('q') }}"
                        placeholder="Search proposals or clients..."
                        class="w-full rounded-2xl border border-slate-200 bg-white py-3 pl-4 pr-10 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-300 focus:ring-4 focus:ring-indigo-100">

                    <button
                        type="submit"
                        class="absolute inset-y-0 right-2 inline-flex items-center rounded-xl px-2 text-slate-400 transition hover:text-slate-600"
                        aria-label="Search">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')">
                    {{ __('Clients') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('proposals.index')" :active="request()->routeIs('proposals.*')">
                    {{ __('Proposals') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('workspace-settings.edit')" :active="request()->routeIs('workspace-settings.*')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('platform-settings.edit')" :active="request()->routeIs('platform-settings.*')">
                    {{ __('Platform') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('search.index')" :active="request()->routeIs('search.index')">
                    {{ __('Global Search') }}
                </x-responsive-nav-link>
            </div>
        </div>

        <div class="border-t border-slate-200 px-4 py-4 sm:px-6">
            <div class="mb-3">
                <div class="font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
