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
                    Password recovery
                </div>

                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-950">
                    Reset your password
                </h1>

                <p class="mt-4 text-base leading-8 text-slate-600">
                    Enter your email address and we’ll send you a secure reset link to get back into
                    {{ $platform->app_name }}.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Secure</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Protected account access</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Fast</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Reset in a few steps</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Return</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Back to your workspace</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-200/50 sm:p-10">
                <div class="mb-8">
                    <p class="text-sm font-medium text-slate-500">Account recovery</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Forgot password</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Tell us your email address and we’ll send you a password reset link.
                    </p>
                </div>

                <x-auth-session-status
                    class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700"
                    :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')"
                            class="mb-2 block text-sm font-semibold text-slate-700" />
                        <x-text-input id="email"
                            class="block w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-400 focus:ring-indigo-400"
                            type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div class="pt-2">
                        <x-primary-button
                            class="w-full justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>

                    <p class="text-center text-sm text-slate-500">
                        Remembered your password?
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                            Log in
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
