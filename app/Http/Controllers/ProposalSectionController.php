<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalSection;
use App\Services\ProposalActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProposalSectionController extends Controller
{
    public function create(Proposal $proposal): View
    {
        $this->authorizeProposal($proposal);

        return view('proposal-sections.create', compact('proposal'));
    }

    public function store(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $validated = $request->validate([
            'type' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ]);

        $nextOrder = ($proposal->sections()->max('sort_order') ?? 0) + 1;

        $proposal->sections()->create([
            ...$validated,
            'sort_order' => $nextOrder,
        ]);

        app(ProposalActivityService::class)->log(
            $proposal,
            'section_added',
            'Section added',
            'A new proposal section was added: ' . $validated['title']
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Section added successfully.');
    }

    public function edit(Proposal $proposal, ProposalSection $section): View
    {
        $this->authorizeProposal($proposal);
        $this->authorizeSection($proposal, $section);

        return view('proposal-sections.edit', compact('proposal', 'section'));
    }

    public function update(Request $request, Proposal $proposal, ProposalSection $section): RedirectResponse
    {
        $this->authorizeProposal($proposal);
        $this->authorizeSection($proposal, $section);

        $validated = $request->validate([
            'type' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ]);

        $section->update($validated);

        app(ProposalActivityService::class)->log(
            $proposal,
            'section_updated',
            'Section updated',
            'A proposal section was updated: ' . $validated['title']
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Proposal $proposal, ProposalSection $section): RedirectResponse
    {
        $this->authorizeProposal($proposal);
        $this->authorizeSection($proposal, $section);

        $sectionTitle = $section->title;

        $section->delete();

        app(ProposalActivityService::class)->log(
            $proposal,
            'section_deleted',
            'Section deleted',
            'A proposal section was deleted: ' . $sectionTitle
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Section deleted successfully.');
    }

    protected function authorizeProposal(Proposal $proposal): void
    {
        abort_unless(
            $proposal->workspace_id === auth()->user()->workspace->id,
            403
        );
    }

    protected function authorizeSection(Proposal $proposal, ProposalSection $section): void
    {
        abort_unless(
            $section->proposal_id === $proposal->id,
            404
        );
    }
}
