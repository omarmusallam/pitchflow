<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use App\Models\Proposal;
use App\Services\ProposalActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ProposalController extends Controller
{
    public function index(): View
    {
        $workspace = auth()->user()->workspace;

        $search = request('search');
        $status = request('status');
        $clientId = request('client_id');
        $sort = request('sort', 'newest');
        $quick = request('quick');
        $alert = request('alert');

        $query = $workspace->proposals()
            ->with('client')
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('notes', 'like', '%' . $search . '%')
                        ->orWhereHas('client', function ($clientQuery) use ($search) {
                            $clientQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('company', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status, fn($query, $status) => $query->where('status', $status))
            ->when($clientId, fn($query, $clientId) => $query->where('client_id', $clientId))
            ->when($alert, function ($query, $alert) {
                return match ($alert) {
                    'expiring' => $query
                        ->whereIn('status', ['draft', 'sent', 'viewed'])
                        ->whereDate('valid_until', '>=', now()->toDateString())
                        ->whereDate('valid_until', '<=', now()->addDays(5)->toDateString()),

                    'viewed_pending' => $query
                        ->where('status', 'viewed')
                        ->where('updated_at', '<', now()->subDays(3)),

                    'stale_sent' => $query
                        ->where('status', 'sent')
                        ->where('updated_at', '<', now()->subDays(7)),

                    default => $query,
                };
            })
            ->when($quick, function ($query, $quick) {
                return match ($quick) {
                    'pipeline' => $query->whereIn('status', ['draft', 'sent', 'viewed']),
                    'accepted' => $query->where('status', 'accepted'),
                    'rejected' => $query->where('status', 'rejected'),
                    'viewed' => $query->where('status', 'viewed'),
                    default => $query,
                };
            });


        $query = match ($sort) {
            'oldest' => $query->oldest(),
            'highest_value' => $query->orderByDesc('total'),
            'lowest_value' => $query->orderBy('total'),
            'title_asc' => $query->orderBy('title'),
            'title_desc' => $query->orderByDesc('title'),
            default => $query->latest(),
        };

        $proposals = $query
            ->paginate(12)
            ->withQueryString();

        $allProposals = $workspace->proposals()->get();
        $clients = $workspace->clients()->orderBy('name')->get();

        $totalProposals = $allProposals->count();
        $acceptedCount = $allProposals->where('status', 'accepted')->count();
        $rejectedCount = $allProposals->where('status', 'rejected')->count();
        $pipelineCount = $allProposals->whereIn('status', ['draft', 'sent', 'viewed'])->count();
        $acceptedRevenue = (float) $allProposals->where('status', 'accepted')->sum('total');

        return view('proposals.index', compact(
            'proposals',
            'clients',
            'search',
            'status',
            'clientId',
            'sort',
            'quick',
            'alert',
            'totalProposals',
            'acceptedCount',
            'rejectedCount',
            'pipelineCount',
            'acceptedRevenue'
        ));
    }

    public function create(): View
    {
        $workspace = auth()->user()->workspace;

        $clients = $workspace->clients()
            ->orderBy('name')
            ->get();

        return view('proposals.create', compact('clients'));
    }

    public function store(StoreProposalRequest $request): RedirectResponse
    {
        $workspace = auth()->user()->workspace;
        $data = $request->validated();

        $proposal = $workspace->proposals()->create([
            'client_id' => $data['client_id'],
            'title' => $data['title'],
            'status' => $data['status'],
            'intro_message' => $data['intro_message'] ?? null,
            'valid_until' => $data['valid_until'] ?? null,
            'discount' => $data['discount'] ?? 0,
            'subtotal' => 0,
            'total' => 0,
            'notes' => $data['notes'] ?? null,
            'public_token' => (string) Str::uuid(),
        ]);

        $this->recalculateProposalTotals($proposal);

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_created',
            'Proposal created',
            'A new proposal was created in the workspace.'
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Proposal created successfully.');
    }

    public function show(Proposal $proposal): View
    {
        $this->authorizeProposal($proposal);

        $proposal->load([
            'client',
            'sections',
            'items',
            'activities',
        ]);

        return view('proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal): View
    {
        $this->authorizeProposal($proposal);

        $workspace = auth()->user()->workspace;

        $clients = $workspace->clients()
            ->orderBy('name')
            ->get();

        return view('proposals.edit', compact('proposal', 'clients'));
    }

    public function update(UpdateProposalRequest $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $data = $request->validated();

        $proposal->update([
            'client_id' => $data['client_id'],
            'title' => $data['title'],
            'status' => $data['status'],
            'intro_message' => $data['intro_message'] ?? null,
            'valid_until' => $data['valid_until'] ?? null,
            'discount' => $data['discount'] ?? 0,
            'notes' => $data['notes'] ?? null,
        ]);

        $this->recalculateProposalTotals($proposal);

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_updated',
            'Proposal updated',
            'Proposal details were updated.'
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $proposal->delete();

        return redirect()
            ->route('proposals.index')
            ->with('success', 'Proposal deleted successfully.');
    }

    public function preview(Proposal $proposal): View
    {
        $this->authorizeProposal($proposal);

        $proposal->load([
            'client',
            'sections',
            'items',
        ]);

        return view('proposals.preview', compact('proposal'));
    }

    public function publicShow(string $token): View
    {
        $proposal = Proposal::with([
            'client',
            'sections',
            'items',
        ])->where('public_token', $token)->firstOrFail();

        if ($proposal->status === 'sent') {
            $proposal->update([
                'status' => 'viewed',
            ]);

            app(ProposalActivityService::class)->log(
                $proposal,
                'proposal_viewed',
                'Proposal viewed',
                'The public proposal link was opened by the client.'
            );

            $proposal->refresh()->load([
                'client',
                'sections',
                'items',
            ]);
        }

        return view('proposals.public', compact('proposal'));
    }

    public function regenerateToken(Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $proposal->update([
            'public_token' => (string) Str::uuid(),
        ]);

        app(ProposalActivityService::class)->log(
            $proposal,
            'public_link_regenerated',
            'Public link regenerated',
            'A new public sharing link was generated for this proposal.'
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Public link regenerated successfully.');
    }

    public function acceptPublic(string $token): RedirectResponse
    {
        $proposal = Proposal::where('public_token', $token)->firstOrFail();

        if (in_array($proposal->status, ['accepted', 'rejected'], true)) {
            return redirect()
                ->route('proposals.public', $proposal->public_token)
                ->with('public_notice', 'This proposal has already been finalized.');
        }

        $proposal->update([
            'status' => 'accepted',
        ]);

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_accepted',
            'Proposal accepted',
            'The client accepted this proposal from the public page.'
        );

        return redirect()
            ->route('proposals.public', $proposal->public_token)
            ->with('public_success', 'Proposal accepted successfully.');
    }

    public function rejectPublic(string $token): RedirectResponse
    {
        $proposal = Proposal::where('public_token', $token)->firstOrFail();

        if (in_array($proposal->status, ['accepted', 'rejected'], true)) {
            return redirect()
                ->route('proposals.public', $proposal->public_token)
                ->with('public_notice', 'This proposal has already been finalized.');
        }

        $proposal->update([
            'status' => 'rejected',
        ]);

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_rejected',
            'Proposal rejected',
            'The client rejected this proposal from the public page.'
        );

        return redirect()
            ->route('proposals.public', $proposal->public_token)
            ->with('public_success', 'Proposal decision recorded successfully.');
    }

    protected function authorizeProposal(Proposal $proposal): void
    {
        abort_unless(
            $proposal->workspace_id === auth()->user()->workspace->id,
            403
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

    public function send(Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        if (in_array($proposal->status, ['accepted', 'rejected'], true)) {
            return redirect()
                ->route('proposals.show', $proposal)
                ->with('success', 'Finalized proposals cannot be sent again.');
        }

        if (! $proposal->public_token) {
            $proposal->update([
                'public_token' => (string) Str::uuid(),
            ]);
        }

        $proposal->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_sent',
            'Proposal sent',
            'The proposal was marked as sent and is ready to be shared with the client.'
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Proposal sent successfully.');
    }

    public function sendScreen(Proposal $proposal): View
    {
        $this->authorizeProposal($proposal);

        if (! $proposal->public_token) {
            $proposal->update([
                'public_token' => (string) Str::uuid(),
            ]);
        }

        $proposal->load('client');

        $recipientEmail = old('recipient_email', $proposal->client?->email ?? '');
        $subject = old('subject', 'Proposal: ' . $proposal->title);

        $message = old(
            'message',
            "Hi {$proposal->client?->name},\n\n" .
                "I hope you're doing well.\n\n" .
                "Please review your proposal using the secure link below:\n\n" .
                route('proposals.public', $proposal->public_token) . "\n\n" .
                "If you have any questions, feel free to reply and I’ll be happy to help.\n\n" .
                "Best regards,\n" .
                auth()->user()->name
        );

        $gmailComposeUrl = 'https://mail.google.com/mail/?view=cm&fs=1&to='
            . urlencode($recipientEmail)
            . '&su=' . urlencode($subject)
            . '&body=' . urlencode($message);

        return view('proposals.send', compact(
            'proposal',
            'recipientEmail',
            'subject',
            'message',
            'gmailComposeUrl'
        ));
    }

    public function prepareEmailDraft(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $validated = $request->validate([
            'recipient_email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $gmailComposeUrl = 'https://mail.google.com/mail/?view=cm&fs=1&to='
            . urlencode($validated['recipient_email'])
            . '&su=' . urlencode($validated['subject'])
            . '&body=' . urlencode($validated['message']);

        if (! $proposal->public_token) {
            $proposal->update([
                'public_token' => (string) Str::uuid(),
            ]);
        }

        if (! in_array($proposal->status, ['accepted', 'rejected'], true)) {
            $proposal->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        }

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_email_draft_prepared',
            'Proposal email draft prepared',
            'A proposal email draft was prepared for the client: ' . $validated['recipient_email']
        );

        session()->flash('email_draft', [
            'recipient_email' => $validated['recipient_email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'gmail_compose_url' => $gmailComposeUrl,
        ]);

        return redirect()
            ->route('proposals.send-screen', $proposal)
            ->with('success', 'Email draft prepared successfully.');
    }

    protected function buildProposalPdf(Proposal $proposal)
    {
        $proposal->load([
            'client',
            'sections',
            'items',
        ]);

        return Pdf::loadView('proposals.pdf', [
            'proposal' => $proposal,
        ])->setPaper('a4', 'portrait');
    }

    public function viewPdf(Proposal $proposal): \Symfony\Component\HttpFoundation\Response
    {
        $this->authorizeProposal($proposal);

        $pdf = $this->buildProposalPdf($proposal);

        $filename = str($proposal->title)
            ->slug('-')
            ->append('-proposal.pdf')
            ->toString();

        return $pdf->stream($filename);
    }

    public function downloadPdf(Proposal $proposal): \Symfony\Component\HttpFoundation\Response
    {
        $this->authorizeProposal($proposal);

        $pdf = $this->buildProposalPdf($proposal);

        $filename = str($proposal->title)
            ->slug('-')
            ->append('-proposal.pdf')
            ->toString();

        return $pdf->download($filename);
    }

    public function deliveryCenter(Proposal $proposal): View
    {
        $this->authorizeProposal($proposal);

        if (! $proposal->public_token) {
            $proposal->update([
                'public_token' => (string) \Illuminate\Support\Str::uuid(),
            ]);
        }

        $proposal->load([
            'client',
            'activities',
        ]);

        $recipientEmail = $proposal->client?->email ?? '';
        $subject = 'Proposal: ' . $proposal->title;

        $message = "Hi {$proposal->client?->name},\n\n"
            . "I hope you're doing well.\n\n"
            . "You can review the proposal using the secure link below:\n\n"
            . route('proposals.public', $proposal->public_token) . "\n\n"
            . "You can also review the PDF version if needed from the delivery center.\n\n"
            . "Best regards,\n"
            . auth()->user()->name;

        $gmailComposeUrl = 'https://mail.google.com/mail/?view=cm&fs=1&to='
            . urlencode($recipientEmail)
            . '&su=' . urlencode($subject)
            . '&body=' . urlencode($message);

        return view('proposals.delivery-center', compact(
            'proposal',
            'recipientEmail',
            'subject',
            'message',
            'gmailComposeUrl'
        ));
    }

    public function markPreparedForDelivery(Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        app(\App\Services\ProposalActivityService::class)->log(
            $proposal,
            'proposal_prepared_for_delivery',
            'Proposal prepared for delivery',
            'The proposal delivery assets were reviewed and prepared for sending.'
        );

        return redirect()
            ->route('proposals.delivery-center', $proposal)
            ->with('success', 'Proposal marked as prepared for delivery.');
    }

    public function markFollowedUp(Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $proposal->update([
            'followed_up_at' => now(),
        ]);

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_followed_up',
            'Proposal followed up',
            'A follow-up action was recorded for this proposal.'
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Follow-up marked successfully.');
    }

    public function snoozeFollowUp(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $validated = $request->validate([
            'days' => ['required', 'integer', 'min:1', 'max:30'],
        ]);

        $remindAt = now()->addDays((int) $validated['days']);

        $proposal->update([
            'follow_up_remind_at' => $remindAt,
        ]);

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_follow_up_snoozed',
            'Follow-up reminder snoozed',
            'The follow-up reminder was snoozed until ' . $remindAt->format('M d, Y h:i A') . '.'
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Follow-up reminder snoozed successfully.');
    }

    public function updateFollowUpNote(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeProposal($proposal);

        $validated = $request->validate([
            'follow_up_note' => ['nullable', 'string'],
        ]);

        $proposal->update([
            'follow_up_note' => $validated['follow_up_note'],
        ]);

        app(ProposalActivityService::class)->log(
            $proposal,
            'proposal_follow_up_note_updated',
            'Follow-up note updated',
            'The follow-up note for this proposal was updated.'
        );

        return redirect()
            ->route('proposals.show', $proposal)
            ->with('success', 'Follow-up note updated successfully.');
    }
}
