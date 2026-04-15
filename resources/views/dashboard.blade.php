<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-indigo-700">
                    <span class="inline-flex h-2 w-2 rounded-full bg-indigo-500"></span>
                    Workspace overview
                </div>

                <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                    {{ platform_settings()->app_name }} Dashboard
                </h2>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600 sm:text-base">
                    Monitor proposal performance, delivery progress, pipeline quality, and follow-up momentum from one
                    premium control center.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('proposals.create') }}"
                    class="inline-flex items-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    New Proposal
                </a>

                <a href="{{ route('clients.create') }}"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    New Client
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Clients</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">{{ $totalClients }}</p>
                <p class="mt-2 text-sm text-slate-500">Active contacts in your workspace</p>
            </div>

            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Proposals</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">{{ $totalProposals }}</p>
                <p class="mt-2 text-sm text-slate-500">Created proposals across all stages</p>
            </div>

            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Acceptance Rate</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">{{ $acceptanceRate }}%</p>
                <p class="mt-2 text-sm text-slate-500">Accepted proposals vs total proposals</p>
            </div>

            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Average Proposal Value</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">
                    ${{ number_format($avgProposalValue, 2) }}</p>
                <p class="mt-2 text-sm text-slate-500">Average total value per proposal</p>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">This Month</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">{{ $thisMonthProposalCount }}</p>
                <p class="mt-2 text-sm text-slate-500">Proposals created this month</p>
            </div>

            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">This Month Accepted</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">{{ $thisMonthAcceptedCount }}</p>
                <p class="mt-2 text-sm text-slate-500">Accepted proposals this month</p>
            </div>

            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">This Month Revenue</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">
                    ${{ number_format($thisMonthRevenue, 2) }}</p>
                <p class="mt-2 text-sm text-slate-500">Accepted revenue this month</p>
            </div>

            <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Monthly Delta</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">
                    {{ $proposalCountDelta >= 0 ? '+' . $proposalCountDelta : $proposalCountDelta }}
                </p>
                <p class="mt-2 text-sm text-slate-500">Compared with last month</p>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-amber-200 bg-gradient-to-br from-amber-50 to-white p-6 shadow-sm">
                <p class="text-sm font-medium text-amber-700">Total Alerts</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-amber-950">{{ $totalFollowUpAlerts }}</p>
                <p class="mt-2 text-sm text-amber-800">Proposals needing review or follow-up</p>
            </div>

            <a href="{{ route('proposals.index', ['alert' => 'expiring']) }}"
                class="block rounded-[28px] border border-orange-200 bg-gradient-to-br from-orange-50 to-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-sm font-medium text-orange-700">Expiring Soon</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-orange-950">{{ $expiringSoonCount }}</p>
                <p class="mt-2 text-sm text-orange-800">Pipeline proposals nearing expiration</p>
            </a>

            <a href="{{ route('proposals.index', ['alert' => 'viewed_pending']) }}"
                class="block rounded-[28px] border border-blue-200 bg-gradient-to-br from-blue-50 to-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-sm font-medium text-blue-700">Viewed but Pending</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-blue-950">{{ $viewedPendingCount }}</p>
                <p class="mt-2 text-sm text-blue-800">Viewed proposals needing follow-up</p>
            </a>

            <a href="{{ route('proposals.index', ['alert' => 'stale_sent']) }}"
                class="block rounded-[28px] border border-rose-200 bg-gradient-to-br from-rose-50 to-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-sm font-medium text-rose-700">Stale Sent</p>
                <p class="mt-4 text-3xl font-bold tracking-tight text-rose-950">{{ $staleSentCount }}</p>
                <p class="mt-2 text-sm text-rose-800">Sent proposals with no recent progress</p>
            </a>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Commercial Overview</p>
                        <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Revenue & pipeline insights
                        </h3>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    <div class="rounded-[24px] bg-emerald-50 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Accepted Revenue
                        </p>
                        <p class="mt-3 text-3xl font-bold tracking-tight text-emerald-950">
                            ${{ number_format((float) $acceptedRevenue, 2) }}
                        </p>
                        <p class="mt-2 text-sm text-emerald-800">
                            Total value of accepted proposals
                        </p>
                    </div>

                    <div class="rounded-[24px] bg-blue-50 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-700">Pipeline Value</p>
                        <p class="mt-3 text-3xl font-bold tracking-tight text-blue-950">
                            ${{ number_format((float) $pipelineValue, 2) }}
                        </p>
                        <p class="mt-2 text-sm text-blue-800">
                            Draft, sent, and viewed proposals still in play
                        </p>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-5">
                    <div class="rounded-[22px] border border-slate-200 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Draft</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $draftCount }}</p>
                    </div>

                    <div class="rounded-[22px] border border-slate-200 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Sent</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $sentCount }}</p>
                    </div>

                    <div class="rounded-[22px] border border-slate-200 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Viewed</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $viewedCount }}</p>
                    </div>

                    <div class="rounded-[22px] border border-slate-200 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Accepted</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $acceptedCount }}</p>
                    </div>

                    <div class="rounded-[22px] border border-slate-200 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Rejected</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $rejectedCount }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Status Distribution</p>
                <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Proposal stage mix</h3>

                <div class="mt-8 space-y-5">
                    @foreach ($statusBreakdown as $status)
                        @php
                            $width = $maxStatusCount > 0 ? max(($status['count'] / $maxStatusCount) * 100, 8) : 8;
                        @endphp

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700">{{ $status['label'] }}</span>
                                <span class="text-slate-500">{{ $status['count'] }}</span>
                            </div>

                            <div class="h-3 rounded-full bg-slate-100">
                                <div class="h-3 rounded-full bg-indigo-500" style="width: {{ $width }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Expiring Soon</p>
                        <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Needs attention soon</h3>
                    </div>

                    <a href="{{ route('proposals.index', ['alert' => 'expiring']) }}"
                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        View all
                    </a>
                </div>

                @if ($expiringSoonProposals->count())
                    <div class="mt-8 space-y-4">
                        @foreach ($expiringSoonProposals->take(5) as $proposal)
                            <div class="rounded-[22px] border border-slate-200 p-4">
                                <a href="{{ route('proposals.show', $proposal) }}"
                                    class="text-sm font-semibold text-slate-900 hover:text-indigo-600">
                                    {{ $proposal->title }}
                                </a>

                                <p class="mt-2 text-sm text-slate-500">
                                    Client: {{ $proposal->client?->name ?? '—' }}
                                </p>

                                <p class="mt-2 text-sm font-medium text-orange-700">
                                    Expires {{ $proposal->valid_until?->diffForHumans() }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="mt-8 rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No proposals expiring soon</p>
                        <p class="mt-2 text-sm text-slate-500">Your active proposal window looks healthy.</p>
                    </div>
                @endif
            </div>

            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Viewed but Pending</p>
                        <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Strong follow-up candidates
                        </h3>
                    </div>

                    <a href="{{ route('proposals.index', ['alert' => 'viewed_pending']) }}"
                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        View all
                    </a>
                </div>

                @if ($viewedPendingProposals->count())
                    <div class="mt-8 space-y-4">
                        @foreach ($viewedPendingProposals->take(5) as $proposal)
                            <div class="rounded-[22px] border border-slate-200 p-4">
                                <a href="{{ route('proposals.show', $proposal) }}"
                                    class="text-sm font-semibold text-slate-900 hover:text-indigo-600">
                                    {{ $proposal->title }}
                                </a>

                                <p class="mt-2 text-sm text-slate-500">
                                    Client: {{ $proposal->client?->name ?? '—' }}
                                </p>

                                <p class="mt-2 text-sm font-medium text-blue-700">
                                    Viewed {{ $proposal->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="mt-8 rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No viewed proposals waiting</p>
                        <p class="mt-2 text-sm text-slate-500">No delayed viewed proposals need follow-up right now.
                        </p>
                    </div>
                @endif
            </div>

            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Stale Sent</p>
                        <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Sent but inactive</h3>
                    </div>

                    <a href="{{ route('proposals.index', ['alert' => 'stale_sent']) }}"
                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        View all
                    </a>
                </div>

                @if ($staleSentProposals->count())
                    <div class="mt-8 space-y-4">
                        @foreach ($staleSentProposals->take(5) as $proposal)
                            <div class="rounded-[22px] border border-slate-200 p-4">
                                <a href="{{ route('proposals.show', $proposal) }}"
                                    class="text-sm font-semibold text-slate-900 hover:text-indigo-600">
                                    {{ $proposal->title }}
                                </a>

                                <p class="mt-2 text-sm text-slate-500">
                                    Client: {{ $proposal->client?->name ?? '—' }}
                                </p>

                                <p class="mt-2 text-sm font-medium text-rose-700">
                                    No recent activity for {{ $proposal->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="mt-8 rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No stale sent proposals</p>
                        <p class="mt-2 text-sm text-slate-500">Your sent pipeline is not showing inactivity issues.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
            <div>
                <p class="text-sm font-medium text-slate-500">Follow-up Recommendations</p>
                <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Suggested next actions</h3>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-[24px] bg-slate-50 p-5">
                    <p class="text-sm font-semibold text-slate-900">Expiring proposals</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Review proposals nearing expiration and decide whether to follow up, extend validity, or refresh
                        the offer.
                    </p>
                </div>

                <div class="rounded-[24px] bg-slate-50 p-5">
                    <p class="text-sm font-semibold text-slate-900">Viewed but pending</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        These proposals already captured attention. A timely follow-up may significantly improve
                        conversion.
                    </p>
                </div>

                <div class="rounded-[24px] bg-slate-50 p-5">
                    <p class="text-sm font-semibold text-slate-900">Stale sent proposals</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Long-pending sent proposals may need a reminder, a revised offer, or a strategic close-out
                        decision.
                    </p>
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Monthly Proposal Volume</p>
                    <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Created proposals over time</h3>
                </div>

                <div class="mt-8">
                    <div class="flex h-64 items-end gap-4">
                        @foreach ($monthlyProposalSeries as $month)
                            @php
                                $height = max(
                                    ($month['total'] / $maxMonthlyProposals) * 100,
                                    $month['total'] > 0 ? 10 : 2,
                                );
                            @endphp

                            <div class="flex flex-1 flex-col items-center gap-3">
                                <div class="flex h-52 w-full items-end">
                                    <div class="w-full rounded-[20px] bg-indigo-500"
                                        style="height: {{ $height }}%;"></div>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-semibold text-slate-900">{{ $month['total'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $month['short_label'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Monthly Revenue</p>
                    <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Accepted revenue by month</h3>
                </div>

                <div class="mt-8 space-y-5">
                    @foreach ($monthlyProposalSeries as $month)
                        @php
                            $width =
                                $maxMonthlyRevenue > 0
                                    ? max(($month['revenue'] / $maxMonthlyRevenue) * 100, $month['revenue'] > 0 ? 8 : 0)
                                    : 0;
                        @endphp

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700">{{ $month['label'] }}</span>
                                <span
                                    class="font-semibold text-slate-900">${{ number_format($month['revenue'], 2) }}</span>
                            </div>

                            <div class="h-3 rounded-full bg-slate-100">
                                <div class="h-3 rounded-full bg-emerald-500" style="width: {{ $width }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Conversion Trend</p>
                    <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Accepted vs rejected by month
                    </h3>
                </div>

                <div class="mt-8 space-y-5">
                    @foreach ($monthlyProposalSeries as $month)
                        @php
                            $acceptedWidth =
                                $maxMonthlyDecisionCount > 0
                                    ? max(
                                        ($month['accepted'] / $maxMonthlyDecisionCount) * 100,
                                        $month['accepted'] > 0 ? 8 : 0,
                                    )
                                    : 0;
                            $rejectedWidth =
                                $maxMonthlyDecisionCount > 0
                                    ? max(
                                        ($month['rejected'] / $maxMonthlyDecisionCount) * 100,
                                        $month['rejected'] > 0 ? 8 : 0,
                                    )
                                    : 0;
                        @endphp

                        <div class="rounded-[22px] border border-slate-200 p-4">
                            <div class="mb-4 flex items-center justify-between">
                                <p class="font-semibold text-slate-900">{{ $month['label'] }}</p>
                                <p class="text-sm text-slate-500">
                                    {{ $month['accepted'] }} accepted / {{ $month['rejected'] }} rejected
                                </p>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <div class="mb-1 flex items-center justify-between text-xs text-slate-500">
                                        <span>Accepted</span>
                                        <span>{{ $month['accepted'] }}</span>
                                    </div>
                                    <div class="h-2.5 rounded-full bg-slate-100">
                                        <div class="h-2.5 rounded-full bg-emerald-500"
                                            style="width: {{ $acceptedWidth }}%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="mb-1 flex items-center justify-between text-xs text-slate-500">
                                        <span>Rejected</span>
                                        <span>{{ $month['rejected'] }}</span>
                                    </div>
                                    <div class="h-2.5 rounded-full bg-slate-100">
                                        <div class="h-2.5 rounded-full bg-red-500"
                                            style="width: {{ $rejectedWidth }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Recent Activity</p>
                <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Workspace timeline</h3>

                @if ($recentActivities->count())
                    <div class="mt-8 space-y-4">
                        @foreach ($recentActivities as $activity)
                            <div class="rounded-[22px] border border-slate-200 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <h4 class="text-sm font-semibold text-slate-900">
                                        {{ $activity->label }}
                                    </h4>
                                    <span class="text-xs text-slate-400">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                @if ($activity->description)
                                    <p class="mt-2 text-sm leading-6 text-slate-600">
                                        {{ $activity->description }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="mt-8 rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No activity yet</p>
                        <p class="mt-2 text-sm text-slate-500">
                            Workspace actions will appear here as you use PitchFlow.
                        </p>
                    </div>
                @endif
            </div>
        </section>

        <section class="rounded-[32px] border border-slate-200/80 bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Recent Proposals</p>
                    <h3 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Latest proposal activity</h3>
                </div>

                <a href="{{ route('proposals.index') }}"
                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                    View all
                </a>
            </div>

            @if ($recentProposals->count())
                <div class="mt-8 overflow-hidden rounded-[24px] border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th
                                    class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    Proposal</th>
                                <th
                                    class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    Client</th>
                                <th
                                    class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    Status</th>
                                <th
                                    class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    Total</th>
                                <th
                                    class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    Updated</th>
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
                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        {{ $proposal->client?->name ?? '—' }}
                                    </td>
                                    <td class="px-5 py-4 text-sm font-medium text-slate-700">
                                        {{ ucfirst($proposal->status) }}
                                    </td>
                                    <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                        ${{ number_format((float) $proposal->total, 2) }}
                                    </td>
                                    <td class="px-5 py-4 text-sm text-slate-500">
                                        {{ $proposal->updated_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div
                    class="mt-8 rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                    <p class="text-base font-semibold text-slate-900">No proposals yet</p>
                    <p class="mt-2 text-sm text-slate-500">
                        Start creating proposals to unlock commercial analytics.
                    </p>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
