<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Proposal delivery</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Send Proposal
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Prepare a professional email draft for sharing this proposal with the client.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('proposals.public', $proposal->public_token) }}" target="_blank"
                    class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    Open Public Link
                </a>

                <a href="{{ $gmailComposeUrl }}" target="_blank"
                    class="inline-flex items-center rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-100 transition">
                    Open in Gmail
                </a>

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
                <div class="mb-6">
                    <p class="text-sm font-medium text-slate-500">Email Draft</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Prepare client message</h3>
                </div>

                <form id="prepare-draft-form" action="{{ route('proposals.prepare-email-draft', $proposal) }}"
                    method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="recipient_email" class="mb-2 block text-sm font-semibold text-slate-700">
                            Recipient Email
                        </label>
                        <input type="email" name="recipient_email" id="recipient_email" value="{{ $recipientEmail }}"
                            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                        @error('recipient_email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="mb-2 block text-sm font-semibold text-slate-700">
                            Subject
                        </label>
                        <input type="text" name="subject" id="subject" value="{{ $subject }}"
                            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                        @error('subject')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="mb-2 block text-sm font-semibold text-slate-700">
                            Message
                        </label>
                        <textarea name="message" id="message" rows="14"
                            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>{{ $message }}</textarea>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="submit" id="prepare-draft-button"
                            class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition disabled:cursor-not-allowed disabled:opacity-70">
                            <span id="prepare-draft-button-label">Prepare Draft</span>
                        </button>

                        <button type="button" data-default-text="Copy Message" data-copied-text="✓ Copied"
                            onclick="copyEmailMessage(this)"
                            class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                            <span class="copy-email-label">Copy Message</span>
                        </button>
                    </div>
                </form>
            </div>

            @if (session('email_draft'))
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <div class="mb-6">
                        <p class="text-sm font-medium text-slate-500">Prepared Draft</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Reviewable output</h3>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">To</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ session('email_draft.recipient_email') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Subject</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ session('email_draft.subject') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Message Body</p>
                            <div class="mt-2 rounded-2xl bg-slate-50 p-5">
                                <p class="whitespace-pre-line text-sm leading-7 text-slate-700">
                                    {{ session('email_draft.message') }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap items-center gap-3">
                            <a href="{{ session('email_draft.gmail_compose_url') }}" target="_blank"
                                class="inline-flex items-center rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-100 transition">
                                Open Draft in Gmail
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Proposal Info</p>

                <div class="mt-6 space-y-4">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Title</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->title }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Client</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->client?->name ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Client Email</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $proposal->client?->email ?? '—' }}
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

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Workflow Note</p>
                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Preparing an email draft marks the proposal as sent when applicable, updates
                    <span class="font-semibold">sent_at</span>, and records this step in the proposal activity timeline.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('prepare-draft-form');
            const button = document.getElementById('prepare-draft-button');
            const label = document.getElementById('prepare-draft-button-label');

            if (form && button && label) {
                form.addEventListener('submit', function() {
                    button.disabled = true;
                    label.textContent = 'Preparing...';
                });
            }
        });

        async function copyEmailMessage(button) {
            const textarea = document.getElementById('message');
            const text = textarea.value;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                } else {
                    fallbackCopy(text);
                }

                markEmailButtonAsCopied(button);
            } catch (error) {
                try {
                    fallbackCopy(text);
                    markEmailButtonAsCopied(button);
                } catch (fallbackError) {
                    console.error(fallbackError);
                }
            }
        }

        function fallbackCopy(text) {
            const temp = document.createElement('textarea');
            temp.value = text;
            temp.style.position = 'fixed';
            temp.style.left = '-9999px';
            temp.style.top = '0';

            document.body.appendChild(temp);
            temp.focus();
            temp.select();
            temp.setSelectionRange(0, text.length);

            const successful = document.execCommand('copy');
            document.body.removeChild(temp);

            if (!successful) {
                throw new Error('Fallback copy failed.');
            }
        }

        function markEmailButtonAsCopied(button) {
            const label = button.querySelector('.copy-email-label');
            const defaultText = button.dataset.defaultText || 'Copy Message';
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
