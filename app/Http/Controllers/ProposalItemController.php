<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Services\ProposalActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProposalItemController extends Controller
{
    public function create(Proposal $proposal): View
    {
        $this->authorizeProposal($proposal);

        return view('proposal-items.create', compact('proposal'));
    }

    public function store(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $nextOrder = ($proposal->items()->max('sort_order') ?? 0) + 1;
        $total = $validated['quantity'] * $validated['unit_price'];

        $proposal->items()->create([
            ...$validated,
            'total' => $total,
            'sort_order' => $nextOrder,
        ]);

        $this->recalculateProposalTotals($proposal);

        app(ProposalActivityService::class)->log(
            $proposal,
            'pricing_item_added',
            'Pricing item added',
            'A new pricing item was added: ' . $validated['name']
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Pricing item added successfully.');
    }

    public function edit(Proposal $proposal, ProposalItem $item): View
    {
        $this->authorizeProposal($proposal);
        $this->authorizeItem($proposal, $item);

        return view('proposal-items.edit', compact('proposal', 'item'));
    }

    public function update(Request $request, Proposal $proposal, ProposalItem $item): RedirectResponse
    {
        $this->authorizeProposal($proposal);
        $this->authorizeItem($proposal, $item);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $item->update([
            ...$validated,
            'total' => $validated['quantity'] * $validated['unit_price'],
        ]);

        $this->recalculateProposalTotals($proposal);

        app(ProposalActivityService::class)->log(
            $proposal,
            'pricing_item_updated',
            'Pricing item updated',
            'A pricing item was updated: ' . $validated['name']
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Pricing item updated successfully.');
    }

    public function destroy(Proposal $proposal, ProposalItem $item): RedirectResponse
    {
        $this->authorizeProposal($proposal);
        $this->authorizeItem($proposal, $item);

        $itemName = $item->name;

        $item->delete();

        $this->recalculateProposalTotals($proposal);

        app(ProposalActivityService::class)->log(
            $proposal,
            'pricing_item_deleted',
            'Pricing item deleted',
            'A pricing item was deleted: ' . $itemName
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Pricing item deleted successfully.');
    }

    protected function authorizeProposal(Proposal $proposal): void
    {
        abort_unless(
            $proposal->workspace_id === auth()->user()->workspace->id,
            403
        );
    }

    protected function authorizeItem(Proposal $proposal, ProposalItem $item): void
    {
        abort_unless(
            $item->proposal_id === $proposal->id,
            404
        );
    }

    protected function recalculateProposalTotals(Proposal $proposal): void
    {
        $proposal->refresh();

        $subtotal = (float) $proposal->items()->sum('total');
        $discount = (float) $proposal->discount;
        $total = max($subtotal - $discount, 0);

        $proposal->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }
}
