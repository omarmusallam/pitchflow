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
                    Verify your email
                </div>

                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-950">
                    Activate your account
                </h1>

                <p class="mt-4 text-base leading-8 text-slate-600">
                    Before getting started, verify your email address so you can securely access your
                    {{ $platform->app_name }} workspace.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Verify</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Confirm your address</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Secure</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Protect your account</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Start</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Access your workspace</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-200/50 sm:p-10">
                <div class="mb-8">
                    <p class="text-sm font-medium text-slate-500">Email verification</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Check your inbox</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        We sent a verification link to your email address. Click it to activate your account.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div
                        class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <x-primary-button
                            class="w-full justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
