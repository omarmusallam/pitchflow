<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Client management</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Clients
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Search, sort, and manage every client contact in your workspace.
                </p>
            </div>

            <a href="{{ route('clients.create') }}"
                class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                New Client
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Clients</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $totalClients }}</p>
                <p class="mt-2 text-sm text-slate-500">All saved workspace contacts</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">With Email</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $clientsWithEmail }}</p>
                <p class="mt-2 text-sm text-slate-500">Clients ready for outreach</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">With Company</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $clientsWithCompany }}</p>
                <p class="mt-2 text-sm text-slate-500">Contacts linked to companies</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">With Phone</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $clientsWithPhone }}</p>
                <p class="mt-2 text-sm text-slate-500">Clients with direct phone details</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-500">Quick Shortcuts</p>
                <h3 class="mt-1 text-lg font-bold text-slate-900">
                    One-click client views
                </h3>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('clients.index') }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ empty($quick) ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    All
                </a>

                <a href="{{ route('clients.index', array_filter(['quick' => 'with_email'])) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $quick === 'with_email' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    With Email
                </a>

                <a href="{{ route('clients.index', array_filter(['quick' => 'with_company'])) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $quick === 'with_company' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    With Company
                </a>

                <a href="{{ route('clients.index', array_filter(['quick' => 'with_phone'])) }}"
                    class="inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition {{ $quick === 'with_phone' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                    With Phone
                </a>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-500">Search & Sort</p>
                <h3 class="mt-1 text-lg font-bold text-slate-900">
                    Refine your client list
                </h3>
            </div>

            <form method="GET" action="{{ route('clients.index') }}"
                class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="xl:col-span-2">
                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">
                        Search
                    </label>
                    <input type="text" name="search" id="search" value="{{ $search }}"
                        placeholder="Name, email, company, phone, notes..."
                        class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="sort" class="mb-2 block text-sm font-semibold text-slate-700">
                        Sort By
                    </label>
                    <select name="sort" id="sort"
                        class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name A–Z</option>
                        <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Name Z–A</option>
                        <option value="company_asc" {{ $sort === 'company_asc' ? 'selected' : '' }}>Company A–Z
                        </option>
                        <option value="company_desc" {{ $sort === 'company_desc' ? 'selected' : '' }}>Company Z–A
                        </option>
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                        Apply
                    </button>

                    <a href="{{ route('clients.index') }}"
                        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if ($search || $quick || ($sort && $sort !== 'newest'))
            <div class="rounded-3xl border border-slate-200 bg-slate-50 px-6 py-4">
                <div class="flex flex-wrap items-center gap-3 text-sm">
                    <span class="font-semibold text-slate-700">Active:</span>

                    @if ($search)
                        <span class="rounded-full bg-white px-3 py-1 text-slate-700 shadow-sm">Search:
                            {{ $search }}</span>
                    @endif

                    @if ($quick)
                        <span class="rounded-full bg-white px-3 py-1 text-slate-700 shadow-sm">
                            Shortcut: {{ str($quick)->replace('_', ' ')->title() }}
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
                    <p class="text-sm font-medium text-slate-500">Client List</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">All workspace clients</h3>
                </div>

                <div class="text-sm text-slate-500">
                    Showing {{ $clients->count() }} client{{ $clients->count() !== 1 ? 's' : '' }}
                </div>
            </div>

            @if ($clients->count())
                <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Client
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Company
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Email
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Phone
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Created
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($clients as $client)
                                    <tr class="align-top">
                                        <td class="px-5 py-4">
                                            <div class="max-w-xs">
                                                <a href="{{ route('clients.show', $client) }}"
                                                    class="font-semibold leading-6 text-slate-900 hover:text-indigo-600">
                                                    {{ $client->name }}
                                                </a>
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            {{ $client->company ?: '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            {{ $client->email ?: '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            {{ $client->phone ?: '—' }}
                                        </td>

                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $client->created_at->format('M d, Y') }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <a href="{{ route('clients.show', $client) }}"
                                                    class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                                    View
                                                </a>

                                                <a href="{{ route('clients.edit', $client) }}"
                                                    class="inline-flex items-center rounded-xl border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 transition">
                                                    Edit
                                                </a>

                                                <form action="{{ route('clients.destroy', $client) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this client?')"
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
                    {{ $clients->links() }}
                </div>
            @else
                <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                    <p class="text-base font-semibold text-slate-900">No clients found</p>
                    <p class="mt-2 text-sm text-slate-500">
                        Try adjusting your filters, changing your sort, or create a new client.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
