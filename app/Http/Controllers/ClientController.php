<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $workspace = auth()->user()->workspace;

        $search = request('search');
        $sort = request('sort', 'newest');
        $quick = request('quick');

        $query = $workspace->clients()
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('company', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('notes', 'like', '%' . $search . '%');
                });
            })
            ->when($quick, function ($query, $quick) {
                return match ($quick) {
                    'with_email' => $query->whereNotNull('email')->where('email', '!=', ''),
                    'with_company' => $query->whereNotNull('company')->where('company', '!=', ''),
                    'with_phone' => $query->whereNotNull('phone')->where('phone', '!=', ''),
                    default => $query,
                };
            });

        $query = match ($sort) {
            'oldest' => $query->oldest(),
            'name_asc' => $query->orderBy('name'),
            'name_desc' => $query->orderByDesc('name'),
            'company_asc' => $query->orderBy('company'),
            'company_desc' => $query->orderByDesc('company'),
            default => $query->latest(),
        };

        $clients = $query
            ->paginate(12)
            ->withQueryString();

        $allClients = $workspace->clients()->get();

        $totalClients = $allClients->count();
        $clientsWithEmail = $allClients->filter(fn($client) => filled($client->email))->count();
        $clientsWithCompany = $allClients->filter(fn($client) => filled($client->company))->count();
        $clientsWithPhone = $allClients->filter(fn($client) => filled($client->phone))->count();

        return view('clients.index', compact(
            'clients',
            'search',
            'sort',
            'quick',
            'totalClients',
            'clientsWithEmail',
            'clientsWithCompany',
            'clientsWithPhone'
        ));
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $workspace = auth()->user()->workspace;

        $workspace->clients()->create($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function show(Client $client): View
    {
        $this->authorizeClient($client);

        $client->load([
            'proposals.items',
        ]);

        $proposals = $client->proposals->sortByDesc('created_at')->values();

        $totalProposals = $proposals->count();
        $acceptedCount = $proposals->where('status', 'accepted')->count();
        $rejectedCount = $proposals->where('status', 'rejected')->count();
        $pendingCount = $proposals->whereIn('status', ['draft', 'sent', 'viewed'])->count();

        $acceptedRevenue = (float) $proposals
            ->where('status', 'accepted')
            ->sum('total');

        $avgProposalValue = $totalProposals > 0
            ? round((float) ($proposals->avg('total') ?? 0), 2)
            : 0;

        $acceptanceRate = $totalProposals > 0
            ? round(($acceptedCount / $totalProposals) * 100, 1)
            : 0;

        $recentProposals = $proposals->take(5);

        return view('clients.show', compact(
            'client',
            'proposals',
            'totalProposals',
            'acceptedCount',
            'rejectedCount',
            'pendingCount',
            'acceptedRevenue',
            'avgProposalValue',
            'acceptanceRate',
            'recentProposals'
        ));
    }

    public function edit(Client $client): View
    {
        $this->authorizeClient($client);

        return view('clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $this->authorizeClient($client);

        $client->update($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->authorizeClient($client);

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    protected function authorizeClient(Client $client): void
    {
        abort_unless(
            $client->workspace_id === auth()->user()->workspace->id,
            403
        );
    }
}
