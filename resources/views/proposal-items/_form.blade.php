@csrf

<div class="grid gap-6">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Item Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $item->name ?? '') }}"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="UI Design Package" required>
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
        <textarea name="description" id="description" rows="4"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Describe what this pricing item includes...">{{ old('description', $item->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="quantity" class="mb-2 block text-sm font-semibold text-slate-700">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1"
                value="{{ old('quantity', $item->quantity ?? 1) }}"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required>
            @error('quantity')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="unit_price" class="mb-2 block text-sm font-semibold text-slate-700">Unit Price</label>
            <input type="number" step="0.01" min="0" name="unit_price" id="unit_price"
                value="{{ old('unit_price', $item->unit_price ?? 0) }}"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required>
            @error('unit_price')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-3">
    <button type="submit"
        class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
        {{ $submitLabel }}
    </button>

    <a href="{{ route('proposals.show', $proposal) }}"
        class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        Cancel
    </a>
</div>
