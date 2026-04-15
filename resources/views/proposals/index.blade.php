<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Proposal performance</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Proposals
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Search, filter, sort, and manage every proposal in your workspace.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('proposals.create') }}"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                    New Proposal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Proposals</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $totalProposals }}</p>
                <p class="mt-2 text-sm text-slate-500">All proposals in this workspace</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Accepted</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $acceptedCount }}</p>
                <p class="mt-2 text-sm text-slate-500">Successfully closed proposals</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Rejected</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $rejectedCount }}</p>
                <p class="mt-2 text-sm text-slate-500">Proposals that were declined</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Pipeline</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $pipelineCount }}</p>
                <p class="mt-2 text-sm text-slate-500">Draft, sent, and viewed proposals</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Accepted Revenue</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">${{ number_format($acceptedRevenue, 2) }}</p>
                <p class="mt-2 text-sm text-slate-500">Closed revenue from accepted work</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-500">Quick Shortcuts</p>
                <h3 class="mt-1 text-lg font-bold text-slate-900">
                    One-click proposal views
                </h3>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('proposals.index') }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ empty($quick) && empty($alert) ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    All
                </a>

                <a href="{{ route('proposals.index', array_filter(['quick' => 'pipeline'])) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $quick === 'pipeline' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    Pipeline
                </a>

                <a href="{{ route('proposals.index', array_filter(['quick' => 'accepted'])) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $quick === 'accepted' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    Accepted
                </a>

                <a href="{{ route('proposals.index', array_filter(['quick' => 'rejected'])) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $quick === 'rejected' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    Rejected
                </a>

                <a href="{{ route('proposals.index', array_filter(['quick' => 'viewed'])) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $quick === 'viewed' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    Viewed
                </a>

                <a href="{{ route('proposals.index', ['alert' => 'expiring']) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $alert === 'expiring' ? 'bg-orange-600 text-white shadow-sm' : 'border border-orange-200 bg-orange-50 text-orange-700 hover:bg-orange-100' }}">
                    Expiring Soon
                </a>

                <a href="{{ route('proposals.index', ['alert' => 'viewed_pending']) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $alert === 'viewed_pending' ? 'bg-blue-600 text-white shadow-sm' : 'border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                    Viewed but Pending
                </a>

                <a href="{{ route('proposals.index', ['alert' => 'stale_sent']) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $alert === 'stale_sent' ? 'bg-rose-600 text-white shadow-sm' : 'border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                    Stale Sent
                </a>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-500">Search, Filters & Sort</p>
                <h3 class="mt-1 text-lg font-bold text-slate-900">
                    Refine your proposal list
                </h3>
            </div>

            <form method="GET" action="{{ route('proposals.index') }}"
                class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                <div>
                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">
                        Search
                    </label>
                    <input type="text" name="search" id="search" value="{{ $search }}"
                        placeholder="Title, notes, client..."
                        class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
                        Status
                    </label>
                    <select name="status" id="status"
                        class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All statuses</option>
                        <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ $status === 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="viewed" {{ $status === 'viewed' ? 'selected' : '' }}>Viewed</option>
                        <option value="accepted" {{ $status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div>
                    <label for="client_id" class="mb-2 block text-sm font-semibold text-slate-700">
                        Client
                    </label>
                    <select name="client_id" id="client_id"
                        class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All clients</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ (string) $clientId === (string) $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="sort" class="mb-2 block text-sm font-semibold text-slate-700">
                        Sort By
                    </label>
                    <select name="sort" id="sort"
                        class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="highest_value" {{ $sort === 'highest_value' ? 'selected' : '' }}>Highest Value
                        </option>
                        <option value="lowest_value" {{ $sort === 'lowest_value' ? 'selected' : '' }}>Lowest Value
                        </option>
                        <option value="title_asc" {{ $sort === 'title_asc' ? 'selected' : '' }}>Title A–Z</option>
                        <option value="title_desc" {{ $sort === 'title_desc' ? 'selected' : '' }}>Title Z–A</option>
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                        Apply
                    </button>

                    <a href="{{ route('proposals.index') }}"
                        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if ($search || $status || $clientId || $quick || $alert || ($sort && $sort !== 'newest'))
            <div class="rounded-3xl border border-slate-200 bg-slate-50 px-6 py-4">
                <div class="flex flex-wrap items-center gap-3 text-sm">
                    <span class="font-semibold text-slate-700">Active:</span>

                    @if ($search)
                        <span class="rounded-full bg-white px-3 py-1 text-slate-700 shadow-sm">
                            Search: {{ $search }}
                        </span>
                    @endif

                    @if ($status)
                        <span class="rounded-full bg-white px-3 py-1 text-slate-700 shadow-sm">
                            Status: {{ ucfirst($status) }}
                        </span>
                    @endif

                    @if ($clientId)
                        @php
                            $selectedClient = $clients->firstWhere('id', (int) $clientId);
                        @endphp
                        <span class="rounded-full bg-white px-3 py-1 text-slate-700 shadow-sm">
                            Client: {{ $selectedClient?->name ?? 'Selected' }}
                        </span>
                    @endif

                    @if ($quick)
                        <span class="rounded-full bg-white px-3 py-1 text-slate-700 shadow-sm">
                            Shortcut: {{ str($quick)->replace('_', ' ')->title() }}
                        </span>
                    @endif

                    @if ($alert)
                        <span class="rounded-full bg-white px-3 py-1 text-slate-700 shadow-sm">
                            Alert:
                            {{ match ($alert) {
                                'expiring' => 'Expiring Soon',
                                'viewed_pending' => 'Viewed but Pending',
                                'stale_sent' => 'Stale Sent',
                                default => ucfirst($alert),
                            } }}
                        </span>
                    @endif

                    @if ($sort && $sort !== 'newest')
                        <span class="rounded-full bg-white px-3 py-1 text-slate-700 shadow-sm">
                            Sort: {{ str($sort)->replace('_', ' ')->title() }}
                        </span>
                    @endif
                </div>
            </div>
        @endif

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Proposal List</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">All workspace proposals</h3>
                </div>

                <div class="text-sm text-slate-500">
                    Showing {{ $proposals->count() }} proposal{{ $proposals->count() !== 1 ? 's' : '' }}
                </div>
            </div>

            @if ($proposals->count())
                <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Proposal
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Client
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Status
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Total
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Updated
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($proposals as $proposal)
                                    @php
                                        $statusClasses = match ($proposal->status) {
                                            'accepted' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                            'rejected' => 'border-red-200 bg-red-50 text-red-700',
                                            'sent' => 'border-blue-200 bg-blue-50 text-blue-700',
                                            'viewed' => 'border-amber-200 bg-amber-50 text-amber-700',
                                            default => 'border-slate-200 bg-slate-50 text-slate-700',
                                        };
                                    @endphp

                                    <tr class="align-top">
                                        <td class="px-5 py-4">
                                            <div class="max-w-xs">
                                                <a href="{{ route('proposals.show', $proposal) }}"
                                                    class="font-semibold leading-6 text-slate-900 hover:text-indigo-600">
                                                    {{ $proposal->title }}
                                                </a>
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            {{ $proposal->client?->name ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <span
                                                class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                                {{ ucfirst($proposal->status) }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                            ${{ number_format((float) $proposal->total, 2) }}
                                        </td>

                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $proposal->updated_at->diffForHumans() }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <a href="{{ route('proposals.show', $proposal) }}"
                                                    class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                                    View
                                                </a>

                                                <a href="{{ route('proposals.edit', $proposal) }}"
                                                    class="inline-flex items-center rounded-xl border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 transition">
                                                    Edit
                                                </a>

                                                <a href="{{ route('proposals.delivery-center', $proposal) }}"
                                                    class="inline-flex items-center rounded-xl border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100 transition">
                                                    Delivery
                                                </a>

                                                <a href="{{ route('proposals.pdf.view', $proposal) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                                    PDF
                                                </a>

                                                <form action="{{ route('proposals.destroy', $proposal) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this proposal?')"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-xl border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100 transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $proposals->links() }}
                </div>
            @else
                <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                    <p class="text-base font-semibold text-slate-900">No proposals found</p>
                    <p class="mt-2 text-sm text-slate-500">
                        Try adjusting your filters, changing your sort, or creating a new proposal.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
