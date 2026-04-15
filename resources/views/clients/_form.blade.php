@csrf

<div class="grid gap-6">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $client->name ?? '') }}"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Client full name" required>
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $client->email ?? '') }}"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="client@example.com">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone ?? '') }}"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="+970 ...">
            @error('phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="company" class="mb-2 block text-sm font-semibold text-slate-700">Company</label>
        <input type="text" name="company" id="company" value="{{ old('company', $client->company ?? '') }}"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Company or brand name">
        @error('company')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="notes" class="mb-2 block text-sm font-semibold text-slate-700">Notes</label>
        <textarea name="notes" id="notes" rows="6"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Add context, project notes, preferences, or internal remarks...">{{ old('notes', $client->notes ?? '') }}</textarea>
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

    <a href="{{ route('clients.index') }}"
        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        Cancel
    </a>
</div>
