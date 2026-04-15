<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Proposal details</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    {{ $proposal->title }}
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Proposal for {{ $proposal->client?->name ?? 'Unknown Client' }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="button" data-copy-link="{{ route('proposals.public', $proposal->public_token) }}"
                    data-default-text="Copy Link" data-copied-text="✓ Copied" onclick="copyProposalLink(this)"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    <span class="copy-link-label">Copy Link</span>
                </button>

                <a href="{{ route('proposals.public', $proposal->public_token) }}" target="_blank"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    Public Link
                </a>

                <a href="{{ route('proposals.preview', $proposal) }}"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    Preview
                </a>

                <form action="{{ route('proposals.regenerate-token', $proposal) }}" method="POST"
                    onsubmit="return confirm('Regenerate the public link? The old link will stop working.')">
                    @csrf

                    <button type="submit"
                        class="inline-flex items-center rounded-2xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm font-semibold text-amber-700 shadow-sm hover:bg-amber-100 transition">
                        Regenerate Link
                    </button>
                </form>

                @if (!in_array($proposal->status, ['accepted', 'rejected']))
                    <form action="{{ route('proposals.send', $proposal) }}" method="POST"
                        onsubmit="return confirm('Mark this proposal as sent?')">
                        @csrf

                        <button type="submit"
                            class="inline-flex items-center rounded-2xl border border-blue-200 bg-blue-50 px-5 py-3 text-sm font-semibold text-blue-700 shadow-sm hover:bg-blue-100 transition">
                            {{ $proposal->status === 'sent' || $proposal->status === 'viewed' ? 'Resend Proposal' : 'Send Proposal' }}
                        </button>
                    </form>
                @endif

                <a href="{{ route('proposals.send-screen', $proposal) }}"
                    class="inline-flex items-center rounded-2xl border border-blue-200 bg-blue-50 px-5 py-3 text-sm font-semibold text-blue-700 shadow-sm hover:bg-blue-100 transition">
                    Email Draft
                </a>

                <a href="{{ route('proposals.edit', $proposal) }}"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                    Edit Proposal
                </a>

                <a href="{{ route('proposals.pdf.view', $proposal) }}" target="_blank"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    View PDF
                </a>

                <a href="{{ route('proposals.pdf', $proposal) }}"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    Download PDF
                </a>

                <a href="{{ route('proposals.delivery-center', $proposal) }}"
                    class="inline-flex items-center rounded-2xl border border-indigo-200 bg-indigo-50 px-5 py-3 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-indigo-100 transition">
                    Delivery Center
                </a>

                <a href="{{ route('proposals.index') }}"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div
            class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $statusClasses = match ($proposal->status) {
            'accepted' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
            'rejected' => 'border-red-200 bg-red-50 text-red-700',
            'sent' => 'border-blue-200 bg-blue-50 text-blue-700',
            'viewed' => 'border-amber-200 bg-amber-50 text-amber-700',
            default => 'border-slate-200 bg-slate-50 text-slate-700',
        };
    @endphp

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Status</p>
                        <div class="mt-3">
                            <span
                                class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                {{ ucfirst($proposal->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-slate-500">Client</p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900">
                            {{ $proposal->client?->name ?? '—' }}
                        </h3>
                    </div>
                </div>

                <div class="mt-8">
                    <p class="text-sm font-medium text-slate-500">Intro Message</p>
                    <p class="mt-3 whitespace-pre-line leading-7 text-slate-700">
                        {{ $proposal->intro_message ?: 'No intro message yet.' }}
                    </p>
                </div>

                <div class="mt-8">
                    <p class="text-sm font-medium text-slate-500">Internal Notes</p>
                    <p class="mt-3 whitespace-pre-line leading-7 text-slate-700">
                        {{ $proposal->notes ?: 'No internal notes yet.' }}
                    </p>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Follow-up Center</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Track client follow-up actions</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Record outreach, postpone reminders, and keep follow-up notes attached to this proposal.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <form action="{{ route('proposals.follow-up', $proposal) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 shadow-sm hover:bg-emerald-100 transition">
                                Mark as Followed Up
                            </button>
                        </form>

                        <form action="{{ route('proposals.snooze-follow-up', $proposal) }}" method="POST"
                            class="flex flex-wrap items-center gap-3">
                            @csrf

                            <select name="days"
                                class="rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1">1 day</option>
                                <option value="3" selected>3 days</option>
                                <option value="5">5 days</option>
                                <option value="7">7 days</option>
                                <option value="14">14 days</option>
                            </select>

                            <button type="submit"
                                class="inline-flex items-center rounded-2xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm font-semibold text-amber-700 shadow-sm hover:bg-amber-100 transition">
                                Snooze Reminder
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Last Follow-Up</p>
                        <p class="mt-3 text-sm font-semibold text-slate-900">
                            {{ $proposal->followed_up_at ? $proposal->followed_up_at->format('M d, Y h:i A') : 'No follow-up recorded yet' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Reminder</p>
                        <p class="mt-3 text-sm font-semibold text-slate-900">
                            {{ $proposal->follow_up_remind_at ? $proposal->follow_up_remind_at->format('M d, Y h:i A') : 'No reminder scheduled' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Status Hint</p>
                        <p class="mt-3 text-sm font-semibold text-slate-900">
                            @if ($proposal->follow_up_remind_at && $proposal->follow_up_remind_at->isPast())
                                Follow-up reminder is due
                            @elseif ($proposal->followed_up_at)
                                Recently followed up
                            @else
                                No follow-up activity yet
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-8">
                    <form action="{{ route('proposals.follow-up-note', $proposal) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <label for="follow_up_note" class="mb-2 block text-sm font-semibold text-slate-700">
                            Follow-up Note
                        </label>

                        <textarea name="follow_up_note" id="follow_up_note" rows="5"
                            placeholder="Add a follow-up note, call summary, next step, or reminder context..."
                            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('follow_up_note', $proposal->follow_up_note) }}</textarea>

                        <div class="mt-4">
                            <button type="submit"
                                class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                                Save Follow-Up Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Proposal Sections</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Structured Content</h3>
                    </div>

                    <a href="{{ route('proposals.sections.create', $proposal) }}"
                        class="inline-flex items-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                        Add Section
                    </a>
                </div>

                @if ($proposal->sections->count())
                    <div class="mt-8 space-y-6">
                        @foreach ($proposal->sections as $section)
                            <div class="rounded-2xl border border-slate-200 p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs uppercase tracking-wide text-slate-400">
                                            {{ $section->type ?: 'custom' }}
                                        </p>
                                        <h4 class="mt-1 text-lg font-semibold text-slate-900">
                                            {{ $section->title }}
                                        </h4>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('proposals.sections.edit', [$proposal, $section]) }}"
                                            class="inline-flex items-center rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('proposals.sections.destroy', [$proposal, $section]) }}"
                                            method="POST" onsubmit="return confirm('Delete this section?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex items-center rounded-xl border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-4 whitespace-pre-line leading-7 text-slate-700">
                                    {{ $section->content ?: 'No content yet.' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No sections yet</p>
                        <p class="mt-2 text-sm text-slate-500">
                            Add overview, scope, deliverables, timeline, or terms to turn this into a complete proposal.
                        </p>
                    </div>
                @endif
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Pricing Items</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Quoted Services</h3>
                    </div>

                    <a href="{{ route('proposals.items.create', $proposal) }}"
                        class="inline-flex items-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                        Add Item
                    </a>
                </div>

                @if ($proposal->items->count())
                    <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Item
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Qty
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Unit Price
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Total
                                    </th>
                                    <th
                                        class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($proposal->items as $item)
                                    <tr>
                                        <td class="px-5 py-4">
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $item->name }}</p>
                                                <p class="mt-1 text-sm text-slate-500">
                                                    {{ $item->description ?: '—' }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-slate-700">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-slate-700">
                                            ${{ number_format((float) $item->unit_price, 2) }}
                                        </td>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                            ${{ number_format((float) $item->total, 2) }}
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('proposals.items.edit', [$proposal, $item]) }}"
                                                    class="inline-flex items-center rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('proposals.items.destroy', [$proposal, $item]) }}"
                                                    method="POST" onsubmit="return confirm('Delete this item?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-xl border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition">
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
                @else
                    <div
                        class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No pricing items yet</p>
                        <p class="mt-2 text-sm text-slate-500">
                            Add billable items to automatically calculate subtotal and final total.
                        </p>
                    </div>
                @endif
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Activity Timeline</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Proposal History</h3>
                    </div>
                </div>

                @if ($proposal->activities->count())
                    <div class="mt-8 space-y-5">
                        @foreach ($proposal->activities as $activity)
                            <div class="flex gap-4">
                                <div class="mt-1 h-3 w-3 rounded-full bg-indigo-500"></div>

                                <div class="flex-1 rounded-2xl border border-slate-200 p-4">
                                    <div class="flex flex-wrap items-center justify-between gap-3">
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
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No activity yet</p>
                        <p class="mt-2 text-sm text-slate-500">
                            Activity will appear here as proposal actions happen.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Financial Summary</p>
                <p class="mt-2 text-sm text-slate-500">
                    Totals update automatically based on proposal pricing items and discount.
                </p>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Subtotal</span>
                        <span class="text-sm font-semibold text-slate-900">
                            ${{ number_format((float) $proposal->subtotal, 2) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Discount</span>
                        <span class="text-sm font-semibold text-slate-900">
                            ${{ number_format((float) $proposal->discount, 2) }}
                        </span>
                    </div>

                    <div class="border-t border-slate-200 pt-4 flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-700">Total</span>
                        <span class="text-lg font-bold text-slate-900">
                            ${{ number_format((float) $proposal->total, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Meta</p>

                <div class="mt-6 space-y-4">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Valid Until</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->valid_until ? $proposal->valid_until->format('M d, Y') : '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Created</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    @if ($proposal->sent_at)
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Sent At</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $proposal->sent_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Last Updated</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->updated_at->format('M d, Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Public Link</p>
                        <p class="mt-1 break-all text-sm font-medium text-slate-700">
                            {{ route('proposals.public', $proposal->public_token) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function copyProposalLink(button) {
            const link = button.dataset.copyLink;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(link);
                } else {
                    fallbackCopy(link);
                }

                markButtonAsCopied(button);
            } catch (error) {
                try {
                    fallbackCopy(link);
                    markButtonAsCopied(button);
                } catch (fallbackError) {
                    console.error(fallbackError);
                }
            }
        }

        function fallbackCopy(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-9999px';
            textArea.style.top = '0';

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            textArea.setSelectionRange(0, text.length);

            const successful = document.execCommand('copy');
            document.body.removeChild(textArea);

            if (!successful) {
                throw new Error('Fallback copy failed.');
            }
        }

        function markButtonAsCopied(button) {
            const label = button.querySelector('.copy-link-label');
            const defaultText = button.dataset.defaultText || 'Copy Link';
            const copiedText = button.dataset.copiedText || '✓ Copied';

            label.textContent = copiedText;

            button.classList.remove('border-slate-200', 'bg-white', 'text-slate-700', 'hover:bg-slate-50');
            button.classList.add('border-emerald-200', 'bg-emerald-50', 'text-emerald-700');

            clearTimeout(button._copyTimeout);

            button._copyTimeout = setTimeout(() => {
                label.textContent = defaultText;

                button.classList.remove('border-emerald-200', 'bg-emerald-50', 'text-emerald-700');
                button.classList.add('border-slate-200', 'bg-white', 'text-slate-700', 'hover:bg-slate-50');
            }, 2000);
        }
    </script>
</x-app-layout>
