<x-guest-layout>
    @php
        $platform = platform_settings();
    @endphp

    <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
        <div class="hidden lg:block">
            <div class="max-w-xl">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-indigo-700">
                    <span class="inline-flex h-2 w-2 rounded-full bg-indigo-500"></span>
                    Welcome back
                </div>

                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-950">
                    Sign in to {{ $platform->app_name }}
                </h1>

                <p class="mt-4 text-base leading-8 text-slate-600">
                    Access your proposal workspace, track delivery progress, and manage follow-ups from one premium
                    dashboard.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Build</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Structured proposals</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Track</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Pipeline visibility</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Deliver</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">PDF and public links</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-200/50 sm:p-10">
                <div class="mb-8">
                    <p class="text-sm font-medium text-slate-500">Account access</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Log in</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Enter your email and password to continue to your workspace.
                    </p>
                </div>

                <x-auth-session-status
                    class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700"
                    :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')"
                            class="mb-2 block text-sm font-semibold text-slate-700" />
                        <x-text-input id="email"
                            class="block w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-400 focus:ring-indigo-400"
                            type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between gap-4">
                            <x-input-label for="password" :value="__('Password')"
                                class="block text-sm font-semibold text-slate-700" />

                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-indigo-600 transition hover:text-indigo-700"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <x-text-input id="password"
                            class="block w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-400 focus:ring-indigo-400"
                            type="password" name="password" required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <label for="remember_me" class="inline-flex items-center gap-3">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <x-primary-button
                            class="w-full justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>

                    @if (Route::has('register'))
                        <p class="text-center text-sm text-slate-500">
                            Don’t have an account?
                            <a href="{{ route('register') }}"
                                class="font-semibold text-indigo-600 hover:text-indigo-700">
                                Create one
                            </a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
