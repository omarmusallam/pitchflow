<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $workspace = $user->workspace;

        abort_unless($workspace, 404);

        $workspace->load([
            'clients',
            'proposals.client',
            'proposals.activities',
        ]);

        $proposals = $workspace->proposals->sortByDesc('created_at')->values();
        $clients = $workspace->clients;

        $totalClients = $clients->count();
        $totalProposals = $proposals->count();

        $draftCount = $proposals->where('status', 'draft')->count();
        $sentCount = $proposals->where('status', 'sent')->count();
        $viewedCount = $proposals->where('status', 'viewed')->count();
        $acceptedCount = $proposals->where('status', 'accepted')->count();
        $rejectedCount = $proposals->where('status', 'rejected')->count();

        $acceptanceRate = $totalProposals > 0
            ? round(($acceptedCount / $totalProposals) * 100, 1)
            : 0;

        $acceptedRevenue = (float) $proposals
            ->where('status', 'accepted')
            ->sum('total');

        $pipelineValue = (float) $proposals
            ->whereIn('status', ['draft', 'sent', 'viewed'])
            ->sum('total');

        $avgProposalValue = $totalProposals > 0
            ? round((float) ($proposals->avg('total') ?? 0), 2)
            : 0;

        $recentProposals = $proposals->take(6);

        $recentActivities = $proposals
            ->flatMap(fn($proposal) => $proposal->activities)
            ->sortByDesc('created_at')
            ->take(8)
            ->values();

        $statusBreakdown = [
            ['label' => 'Draft', 'count' => $draftCount],
            ['label' => 'Sent', 'count' => $sentCount],
            ['label' => 'Viewed', 'count' => $viewedCount],
            ['label' => 'Accepted', 'count' => $acceptedCount],
            ['label' => 'Rejected', 'count' => $rejectedCount],
        ];

        $maxStatusCount = max(array_column($statusBreakdown, 'count')) ?: 1;

        // Monthly analytics
        $months = collect(range(5, 1, -1))
            ->map(fn($offset) => Carbon::now()->startOfMonth()->subMonths($offset))
            ->push(Carbon::now()->startOfMonth())
            ->values();

        $monthlyProposalSeries = $months->map(function ($month) use ($proposals) {
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $monthProposals = $proposals->filter(function ($proposal) use ($monthStart, $monthEnd) {
                return $proposal->created_at->between($monthStart, $monthEnd);
            });

            return [
                'label' => $month->format('M Y'),
                'short_label' => $month->format('M'),
                'total' => $monthProposals->count(),
                'accepted' => $monthProposals->where('status', 'accepted')->count(),
                'rejected' => $monthProposals->where('status', 'rejected')->count(),
                'revenue' => (float) $monthProposals->where('status', 'accepted')->sum('total'),
            ];
        });

        $maxMonthlyProposals = max($monthlyProposalSeries->pluck('total')->max() ?? 0, 1);
        $maxMonthlyRevenue = max($monthlyProposalSeries->pluck('revenue')->max() ?? 0, 1);
        $maxMonthlyDecisionCount = max(
            $monthlyProposalSeries->pluck('accepted')->max() ?? 0,
            $monthlyProposalSeries->pluck('rejected')->max() ?? 0,
            1
        );

        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->startOfMonth()->subMonth();

        $currentMonthProposals = $proposals->filter(
            fn($proposal) => $proposal->created_at->between(
                $currentMonth->copy()->startOfMonth(),
                $currentMonth->copy()->endOfMonth()
            )
        );

        $previousMonthProposals = $proposals->filter(
            fn($proposal) => $proposal->created_at->between(
                $previousMonth->copy()->startOfMonth(),
                $previousMonth->copy()->endOfMonth()
            )
        );

        $thisMonthProposalCount = $currentMonthProposals->count();
        $lastMonthProposalCount = $previousMonthProposals->count();
        $thisMonthAcceptedCount = $currentMonthProposals->where('status', 'accepted')->count();
        $thisMonthRevenue = (float) $currentMonthProposals->where('status', 'accepted')->sum('total');
        $proposalCountDelta = $thisMonthProposalCount - $lastMonthProposalCount;

        // =========================
        // Follow-up alerts
        // =========================
        $today = Carbon::today();
        $expiringSoonThreshold = Carbon::today()->addDays(5);
        $staleSentThreshold = Carbon::today()->subDays(7);
        $viewedPendingThreshold = Carbon::today()->subDays(3);

        $expiringSoonProposals = $proposals
            ->filter(function ($proposal) use ($today, $expiringSoonThreshold) {
                return $proposal->valid_until
                    && in_array($proposal->status, ['draft', 'sent', 'viewed'], true)
                    && $proposal->valid_until->between($today, $expiringSoonThreshold);
            })
            ->sortBy('valid_until')
            ->values();

        $viewedPendingProposals = $proposals
            ->filter(function ($proposal) use ($viewedPendingThreshold) {
                return $proposal->status === 'viewed'
                    && $proposal->updated_at->lt($viewedPendingThreshold);
            })
            ->sortBy('updated_at')
            ->values();

        $staleSentProposals = $proposals
            ->filter(function ($proposal) use ($staleSentThreshold) {
                return $proposal->status === 'sent'
                    && $proposal->updated_at->lt($staleSentThreshold);
            })
            ->sortBy('updated_at')
            ->values();

        $expiringSoonCount = $expiringSoonProposals->count();
        $viewedPendingCount = $viewedPendingProposals->count();
        $staleSentCount = $staleSentProposals->count();
        $totalFollowUpAlerts = $expiringSoonCount + $viewedPendingCount + $staleSentCount;

        return view('dashboard', compact(
            'totalClients',
            'totalProposals',
            'draftCount',
            'sentCount',
            'viewedCount',
            'acceptedCount',
            'rejectedCount',
            'acceptanceRate',
            'acceptedRevenue',
            'pipelineValue',
            'avgProposalValue',
            'recentProposals',
            'recentActivities',
            'statusBreakdown',
            'maxStatusCount',
            'monthlyProposalSeries',
            'maxMonthlyProposals',
            'maxMonthlyRevenue',
            'maxMonthlyDecisionCount',
            'thisMonthProposalCount',
            'thisMonthAcceptedCount',
            'thisMonthRevenue',
            'proposalCountDelta',
            'expiringSoonProposals',
            'viewedPendingProposals',
            'staleSentProposals',
            'expiringSoonCount',
            'viewedPendingCount',
            'staleSentCount',
            'totalFollowUpAlerts'
        ));
    }
}
