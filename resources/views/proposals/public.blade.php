<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $proposal->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (session('public_success'))
                <div
                    class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                    {{ session('public_success') }}
                </div>
            @endif

            @if (session('public_notice'))
                <div
                    class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700">
                    {{ session('public_notice') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div
                    class="border-b border-slate-200 bg-gradient-to-r from-slate-950 via-slate-900 to-indigo-950 px-8 py-10 text-white sm:px-12">
                    <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-3xl">
                            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-indigo-300">
                                Proposal
                            </p>

                            <h1 class="mt-4 text-4xl font-bold tracking-tight">
                                {{ $proposal->title }}
                            </h1>

                            <p class="mt-4 max-w-2xl text-base leading-7 text-slate-300">
                                {{ $proposal->intro_message ?: 'A professional proposal prepared for your review.' }}
                            </p>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
                            <p class="text-xs uppercase tracking-wide text-slate-300">Prepared for</p>
                            <h2 class="mt-2 text-2xl font-bold">
                                {{ $proposal->client?->name ?? 'Unknown Client' }}
                            </h2>
                            <p class="mt-2 text-sm text-slate-300">
                                {{ $proposal->client?->company ?: 'Independent Client' }}
                            </p>

                            @if ($proposal->valid_until)
                                <p class="mt-4 text-sm text-indigo-200">
                                    Valid until {{ $proposal->valid_until->format('M d, Y') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid gap-0 lg:grid-cols-3">
                    <div class="lg:col-span-2 border-b border-slate-200 p-8 sm:p-12 lg:border-b-0 lg:border-r">
                        @if ($proposal->sections->count())
                            <div class="space-y-10">
                                @foreach ($proposal->sections as $section)
                                    <section>
                                        <div class="mb-4">
                                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                                {{ $section->type ?: 'section' }}
                                            </p>
                                            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                                                {{ $section->title }}
                                            </h2>
                                        </div>

                                        <div class="prose prose-slate max-w-none whitespace-pre-line leading-8">
                                            {{ $section->content ?: 'No content available.' }}
                                        </div>
                                    </section>
                                @endforeach
                            </div>
                        @else
                            <div
                                class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                                <p class="text-lg font-semibold text-slate-900">No proposal sections yet</p>
                                <p class="mt-2 text-sm text-slate-500">
                                    This proposal does not yet contain structured content sections.
                                </p>
                            </div>
                        @endif
                    </div>

                    <aside class="bg-slate-50/70 p-8 sm:p-10">
                        <div class="space-y-8">
                            @if (!in_array($proposal->status, ['accepted', 'rejected']))
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                        Decision
                                    </p>

                                    <div class="mt-5 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                                        <p class="text-sm leading-6 text-slate-600">
                                            You can review this proposal and confirm your decision below.
                                        </p>

                                        <div class="mt-5 flex flex-col gap-3">
                                            <form
                                                action="{{ route('proposals.public.accept', $proposal->public_token) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">
                                                    Accept Proposal
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('proposals.public.reject', $proposal->public_token) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to reject this proposal?')">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-100 transition">
                                                    Reject Proposal
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                        Decision Status
                                    </p>

                                    <div class="mt-5 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                                        @if ($proposal->status === 'accepted')
                                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4">
                                                <p class="text-sm font-semibold text-emerald-700">
                                                    This proposal has been accepted.
                                                </p>
                                            </div>
                                        @elseif ($proposal->status === 'rejected')
                                            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4">
                                                <p class="text-sm font-semibold text-red-700">
                                                    This proposal has been rejected.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                    Proposal Summary
                                </p>

                                <div class="mt-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-slate-500">Status</span>

                                        @php
                                            $publicStatusClasses = match ($proposal->status) {
                                                'accepted' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                                'rejected' => 'border-red-200 bg-red-50 text-red-700',
                                                'sent' => 'border-blue-200 bg-blue-50 text-blue-700',
                                                'viewed' => 'border-amber-200 bg-amber-50 text-amber-700',
                                                default => 'border-slate-200 bg-slate-50 text-slate-700',
                                            };
                                        @endphp

                                        <span
                                            class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $publicStatusClasses }}">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                    </div>

                                    <div class="mt-6 space-y-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-slate-500">Subtotal</span>
                                            <span class="text-sm font-semibold text-slate-900">
                                                ${{ number_format((float) $proposal->subtotal, 2) }}
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-slate-500">Discount</span>
                                            <span class="text-sm font-semibold text-slate-900">
                                                ${{ number_format((float) $proposal->discount, 2) }}
                                            </span>
                                        </div>

                                        <div class="border-t border-slate-200 pt-4 flex items-center justify-between">
                                            <span class="text-sm font-semibold text-slate-700">Total</span>
                                            <span class="text-2xl font-bold text-slate-900">
                                                ${{ number_format((float) $proposal->total, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                    Pricing Items
                                </p>

                                @if ($proposal->items->count())
                                    <div class="mt-5 space-y-4">
                                        @foreach ($proposal->items as $item)
                                            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                                                <div class="flex items-start justify-between gap-4">
                                                    <div>
                                                        <h3 class="font-semibold text-slate-900">
                                                            {{ $item->name }}
                                                        </h3>
                                                        <p class="mt-1 text-sm leading-6 text-slate-500">
                                                            {{ $item->description ?: '—' }}
                                                        </p>
                                                    </div>

                                                    <div class="text-right">
                                                        <p class="text-xs uppercase tracking-wide text-slate-400">
                                                            Qty {{ $item->quantity }}
                                                        </p>
                                                        <p class="mt-2 font-semibold text-slate-900">
                                                            ${{ number_format((float) $item->total, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="mt-5 rounded-3xl border border-dashed border-slate-300 bg-white px-5 py-8 text-center">
                                        <p class="text-sm font-semibold text-slate-900">No pricing items yet</p>
                                        <p class="mt-2 text-sm text-slate-500">
                                            This proposal does not include billable items yet.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            @if ($proposal->notes)
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                        Additional Notes
                                    </p>

                                    <div class="mt-5 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                                        <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
                                            {{ $proposal->notes }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
