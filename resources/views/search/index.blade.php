<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Global search</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Search Results
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Search across proposals and clients from one place.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <form action="{{ route('search.index') }}" method="GET" class="flex flex-col gap-4 md:flex-row">
                <div class="flex-1">
                    <label for="q" class="mb-2 block text-sm font-semibold text-slate-700">
                        Search
                    </label>
                    <input type="text" name="q" id="q" value="{{ $query }}"
                        placeholder="Search proposals, clients, companies..."
                        class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                        Search
                    </button>

                    <a href="{{ route('search.index') }}"
                        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if ($query === '')
            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                <p class="text-lg font-semibold text-slate-900">Start typing to search</p>
                <p class="mt-2 text-sm text-slate-500">
                    Find proposals and clients quickly across your workspace.
                </p>
            </div>
        @else
            <div class="grid gap-6 xl:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Proposals</p>
                            <h3 class="mt-1 text-xl font-bold text-slate-900">
                                Matching proposals
                            </h3>
                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            {{ $proposalResults->count() }}
                        </span>
                    </div>

                    @if ($proposalResults->count())
                        <div class="mt-8 space-y-4">
                            @foreach ($proposalResults as $proposal)
                                @php
                                    $statusClasses = match ($proposal->status) {
                                        'accepted' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                        'rejected' => 'border-red-200 bg-red-50 text-red-700',
                                        'sent' => 'border-blue-200 bg-blue-50 text-blue-700',
                                        'viewed' => 'border-amber-200 bg-amber-50 text-amber-700',
                                        default => 'border-slate-200 bg-slate-50 text-slate-700',
                                    };
                                @endphp

                                <div class="rounded-2xl border border-slate-200 p-5">
                                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                        <div>
                                            <a href="{{ route('proposals.show', $proposal) }}"
                                                class="text-base font-semibold text-slate-900 hover:text-indigo-600">
                                                {{ $proposal->title }}
                                            </a>

                                            <p class="mt-2 text-sm text-slate-500">
                                                Client: {{ $proposal->client?->name ?? '—' }}
                                            </p>

                                            <p class="mt-2 text-sm font-semibold text-slate-900">
                                                ${{ number_format((float) $proposal->total, 2) }}
                                            </p>
                                        </div>

                                        <span
                                            class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                    </div>

                                    <div class="mt-4 flex flex-wrap items-center gap-2">
                                        <a href="{{ route('proposals.show', $proposal) }}"
                                            class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                            Open
                                        </a>

                                        <a href="{{ route('proposals.delivery-center', $proposal) }}"
                                            class="inline-flex items-center rounded-xl border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100 transition">
                                            Delivery
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                            <p class="text-base font-semibold text-slate-900">No matching proposals</p>
                            <p class="mt-2 text-sm text-slate-500">
                                No proposals matched your current search query.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Clients</p>
                            <h3 class="mt-1 text-xl font-bold text-slate-900">
                                Matching clients
                            </h3>
                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            {{ $clientResults->count() }}
                        </span>
                    </div>

                    @if ($clientResults->count())
                        <div class="mt-8 space-y-4">
                            @foreach ($clientResults as $client)
                                <div class="rounded-2xl border border-slate-200 p-5">
                                    <a href="{{ route('clients.show', $client) }}"
                                        class="text-base font-semibold text-slate-900 hover:text-indigo-600">
                                        {{ $client->name }}
                                    </a>

                                    <p class="mt-2 text-sm text-slate-500">
                                        {{ $client->company ?: 'Independent client' }}
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600">
                                        {{ $client->email ?: 'No email available' }}
                                    </p>

                                    <div class="mt-4 flex flex-wrap items-center gap-2">
                                        <a href="{{ route('clients.show', $client) }}"
                                            class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                            Open
                                        </a>

                                        <a href="{{ route('clients.edit', $client) }}"
                                            class="inline-flex items-center rounded-xl border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 transition">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                            <p class="text-base font-semibold text-slate-900">No matching clients</p>
                            <p class="mt-2 text-sm text-slate-500">
                                No clients matched your current search query.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
