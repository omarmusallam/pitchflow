<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Client insights</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    {{ $client->name }}
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    {{ $client->company ?: 'Independent client' }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('clients.edit', $client) }}"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                    Edit Client
                </a>

                <a href="{{ route('clients.index') }}"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Proposals</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $totalProposals }}</p>
                <p class="mt-2 text-sm text-slate-500">All proposals for this client</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Acceptance Rate</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">{{ $acceptanceRate }}%</p>
                <p class="mt-2 text-sm text-slate-500">Accepted proposals vs total</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Accepted Revenue</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">${{ number_format($acceptedRevenue, 2) }}</p>
                <p class="mt-2 text-sm text-slate-500">Closed revenue from accepted proposals</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Average Proposal Value</p>
                <p class="mt-4 text-3xl font-bold text-slate-900">${{ number_format($avgProposalValue, 2) }}</p>
                <p class="mt-2 text-sm text-slate-500">Average proposal total for this client</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Proposal History</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Recent proposals for this client</h3>
                    </div>
                </div>

                @if ($recentProposals->count())
                    <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Proposal</th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Status</th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Total</th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Created</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($recentProposals as $proposal)
                                    <tr>
                                        <td class="px-5 py-4">
                                            <a href="{{ route('proposals.show', $proposal) }}"
                                                class="font-semibold text-slate-900 hover:text-indigo-600">
                                                {{ $proposal->title }}
                                            </a>
                                        </td>
                                        <td class="px-5 py-4 text-sm font-medium text-slate-700">
                                            {{ ucfirst($proposal->status) }}
                                        </td>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                            ${{ number_format((float) $proposal->total, 2) }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-slate-500">
                                            {{ $proposal->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div
                        class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No proposals yet</p>
                        <p class="mt-2 text-sm text-slate-500">
                            This client does not have any linked proposals yet.
                        </p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Client Snapshot</p>

                    <div class="mt-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Accepted</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $acceptedCount }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Rejected</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $rejectedCount }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Pending</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $pendingCount }}</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Contact Details</p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Email</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $client->email ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Phone</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $client->phone ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Company</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $client->company ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Created</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $client->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
