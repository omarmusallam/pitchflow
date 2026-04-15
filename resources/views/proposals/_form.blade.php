@csrf

<div class="grid gap-6">
    <div>
        <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Proposal Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $proposal->title ?? '') }}"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Website Redesign Proposal" required>
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="client_id" class="mb-2 block text-sm font-semibold text-slate-700">Client</label>
            <select name="client_id" id="client_id"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required>
                <option value="">Select client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" @selected(old('client_id', $proposal->client_id ?? '') == $client->id)>
                        {{ $client->name }}{{ $client->company ? ' — ' . $client->company : '' }}
                    </option>
                @endforeach
            </select>
            @error('client_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
            <select name="status" id="status"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required>
                @foreach (['draft', 'sent', 'viewed', 'accepted', 'rejected'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $proposal->status ?? 'draft') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="intro_message" class="mb-2 block text-sm font-semibold text-slate-700">Intro Message</label>
        <textarea name="intro_message" id="intro_message" rows="5"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Thank you for the opportunity. This proposal outlines the scope, timeline, and investment for your project...">{{ old('intro_message', $proposal->intro_message ?? '') }}</textarea>
        @error('intro_message')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="valid_until" class="mb-2 block text-sm font-semibold text-slate-700">Valid Until</label>
            <input type="date" name="valid_until" id="valid_until"
                value="{{ old('valid_until', isset($proposal->valid_until) ? $proposal->valid_until->format('Y-m-d') : '') }}"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('valid_until')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="discount" class="mb-2 block text-sm font-semibold text-slate-700">Discount</label>
            <input type="number" step="0.01" min="0" name="discount" id="discount"
                value="{{ old('discount', $proposal->discount ?? 0) }}"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('discount')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-4">
        <p class="text-sm font-semibold text-slate-900">Pricing totals are calculated automatically</p>
        <p class="mt-1 text-sm leading-6 text-slate-500">
            Subtotal and final total are generated from proposal pricing items. Add or edit pricing items after saving
            the proposal.
        </p>
    </div>

    <div>
        <label for="notes" class="mb-2 block text-sm font-semibold text-slate-700">Internal Notes</label>
        <textarea name="notes" id="notes" rows="5"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Optional internal notes about this proposal...">{{ old('notes', $proposal->notes ?? '') }}</textarea>
        @error('notes')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-3">
    <button type="submit"
        class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
        {{ $submitLabel }}
    </button>

    <a href="{{ route('proposals.index') }}"
        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        Cancel
    </a>
</div>
