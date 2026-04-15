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
                    Set a new password
                </div>

                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-950">
                    Choose a new password
                </h1>

                <p class="mt-4 text-base leading-8 text-slate-600">
                    Create a strong new password for your {{ $platform->app_name }} account and continue back to your
                    workspace securely.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Access</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Restore your account</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Secure</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Update credentials safely</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Continue</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Return to your workflow</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-200/50 sm:p-10">
                <div class="mb-8">
                    <p class="text-sm font-medium text-slate-500">Password reset</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Reset password</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Enter your email and set a new password to complete account recovery.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <x-input-label for="email" :value="__('Email')"
                            class="mb-2 block text-sm font-semibold text-slate-700" />
                        <x-text-input id="email"
                            class="block w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-400 focus:ring-indigo-400"
                            type="email" name="email" :value="old('email', $request->email)" required autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')"
                            class="mb-2 block text-sm font-semibold text-slate-700" />
                        <x-text-input id="password"
                            class="block w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-400 focus:ring-indigo-400"
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                            class="mb-2 block text-sm font-semibold text-slate-700" />
                        <x-text-input id="password_confirmation"
                            class="block w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-400 focus:ring-indigo-400"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div class="pt-2">
                        <x-primary-button
                            class="w-full justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </div>

                    <p class="text-center text-sm text-slate-500">
                        Back to
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                            login
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
