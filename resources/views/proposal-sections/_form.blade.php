@csrf

<div class="grid gap-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">Section Type</label>
            <select name="type" id="type"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @php
                    $types = [
                        'overview' => 'Project Overview',
                        'scope' => 'Scope of Work',
                        'deliverables' => 'Deliverables',
                        'timeline' => 'Timeline',
                        'investment' => 'Investment',
                        'terms' => 'Terms',
                        'custom' => 'Custom',
                    ];
                @endphp

                <option value="">Select section type</option>

                @foreach ($types as $value => $label)
                    <option value="{{ $value }}" @selected(old('type', $section->type ?? '') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Section Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $section->title ?? '') }}"
                class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Project Overview" required>
            @error('title')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="content" class="mb-2 block text-sm font-semibold text-slate-700">Content</label>
        <textarea name="content" id="content" rows="12"
            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Write the section content here...">{{ old('content', $section->content ?? '') }}</textarea>
        @error('content')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
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
