<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Proposal delivery</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Delivery Center
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Manage every delivery method for this proposal from one place.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('proposals.show', $proposal) }}"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Back to Proposal
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

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Delivery Overview</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">
                            {{ $proposal->title }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Prepared for {{ $proposal->client?->name ?? 'Unknown Client' }}
                        </p>
                    </div>

                    <form action="{{ route('proposals.mark-prepared-for-delivery', $proposal) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                            Mark Ready
                        </button>
                    </form>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Proposal Status</p>
                        <p class="mt-3 text-lg font-bold text-slate-900">
                            {{ ucfirst($proposal->status) }}
                        </p>
                        @if ($proposal->sent_at)
                            <p class="mt-2 text-sm text-slate-500">
                                Sent at {{ $proposal->sent_at->format('M d, Y h:i A') }}
                            </p>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Recipient</p>
                        <p class="mt-3 text-lg font-bold text-slate-900">
                            {{ $proposal->client?->name ?? '—' }}
                        </p>
                        <p class="mt-2 text-sm text-slate-500">
                            {{ $proposal->client?->email ?? 'No email available' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Public Proposal Access</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Secure share link</h3>
                </div>

                <div class="mt-6 rounded-2xl bg-slate-50 p-4">
                    <p class="break-all text-sm font-medium text-slate-700">
                        {{ route('proposals.public', $proposal->public_token) }}
                    </p>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <button type="button" data-copy-link="{{ route('proposals.public', $proposal->public_token) }}"
                        data-default-text="Copy Public Link" data-copied-text="✓ Copied"
                        onclick="copyDeliveryLink(this)"
                        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        <span class="copy-delivery-label">Copy Public Link</span>
                    </button>

                    <a href="{{ route('proposals.public', $proposal->public_token) }}" target="_blank"
                        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        Open Public Link
                    </a>

                    <form action="{{ route('proposals.regenerate-token', $proposal) }}" method="POST"
                        onsubmit="return confirm('Regenerate the public link? The old link will stop working.')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-2xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm font-semibold text-amber-700 shadow-sm hover:bg-amber-100 transition">
                            Regenerate Link
                        </button>
                    </form>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">PDF Delivery</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Printable proposal version</h3>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a href="{{ route('proposals.pdf.view', $proposal) }}" target="_blank"
                        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        View PDF
                    </a>

                    <a href="{{ route('proposals.pdf', $proposal) }}"
                        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        Download PDF
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Email Delivery</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Prepared client message</h3>
                </div>

                <div class="mt-6 space-y-5">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">To</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ $recipientEmail ?: '—' }}</p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Subject</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ $subject }}</p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Message</p>
                        <div class="mt-2 rounded-2xl bg-slate-50 p-5">
                            <p class="whitespace-pre-line text-sm leading-7 text-slate-700">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <button type="button" data-default-text="Copy Message" data-copied-text="✓ Copied"
                        onclick="copyEmailDelivery(this)"
                        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        <span class="copy-email-delivery-label">Copy Message</span>
                    </button>

                    <a href="{{ route('proposals.send-screen', $proposal) }}"
                        class="inline-flex items-center rounded-2xl border border-blue-200 bg-blue-50 px-5 py-3 text-sm font-semibold text-blue-700 shadow-sm hover:bg-blue-100 transition">
                        Open Email Draft Screen
                    </a>

                    <a href="{{ $gmailComposeUrl }}" target="_blank"
                        class="inline-flex items-center rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-100 transition">
                        Open in Gmail
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Delivery Activity</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Recent delivery-related actions</h3>
                </div>

                @php
                    $deliveryActivities = $proposal->activities->filter(function ($activity) {
                        return in_array($activity->type, [
                            'proposal_sent',
                            'proposal_viewed',
                            'public_link_regenerated',
                            'proposal_email_draft_prepared',
                            'proposal_prepared_for_delivery',
                        ]);
                    });
                @endphp

                @if ($deliveryActivities->count())
                    <div class="mt-8 space-y-4">
                        @foreach ($deliveryActivities as $activity)
                            <div class="rounded-2xl border border-slate-200 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <h4 class="text-sm font-semibold text-slate-900">{{ $activity->label }}</h4>
                                    <span
                                        class="text-xs text-slate-400">{{ $activity->created_at->diffForHumans() }}</span>
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
                        class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                        <p class="text-base font-semibold text-slate-900">No delivery activity yet</p>
                        <p class="mt-2 text-sm text-slate-500">
                            Delivery actions will appear here as you prepare and share the proposal.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Delivery Checklist</p>

                <div class="mt-6 space-y-4 text-sm text-slate-700">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        Public link is ready
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        PDF version is available
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        Email message is prepared
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        Delivery status can be tracked
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Client Info</p>

                <div class="mt-6 space-y-4">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Name</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->client?->name ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Email</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->client?->email ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Company</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->client?->company ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function copyDeliveryLink(button) {
            const link = button.dataset.copyLink;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(link);
                } else {
                    fallbackCopy(link);
                }

                markButtonCopied(button, '.copy-delivery-label');
            } catch (error) {
                try {
                    fallbackCopy(link);
                    markButtonCopied(button, '.copy-delivery-label');
                } catch (fallbackError) {
                    console.error(fallbackError);
                }
            }
        }

        async function copyEmailDelivery(button) {
            const text = @json($message);

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                } else {
                    fallbackCopy(text);
                }

                markButtonCopied(button, '.copy-email-delivery-label');
            } catch (error) {
                try {
                    fallbackCopy(text);
                    markButtonCopied(button, '.copy-email-delivery-label');
                } catch (fallbackError) {
                    console.error(fallbackError);
                }
            }
        }

        function fallbackCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            textarea.style.top = '0';

            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();
            textarea.setSelectionRange(0, text.length);

            const successful = document.execCommand('copy');
            document.body.removeChild(textarea);

            if (!successful) {
                throw new Error('Copy failed.');
            }
        }

        function markButtonCopied(button, selector) {
            const label = button.querySelector(selector);
            const defaultText = button.dataset.defaultText;
            const copiedText = button.dataset.copiedText;

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
