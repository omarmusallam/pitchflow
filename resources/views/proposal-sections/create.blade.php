<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-slate-500">Proposal sections</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Add Section
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Add a structured content block to this proposal.
            </p>
        </div>
    </x-slot>

    <div class="max-w-5xl">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="{{ route('proposals.sections.store', $proposal) }}" method="POST">
                @include('proposal-sections._form', [
                    'submitLabel' => 'Add Section',
                    'section' => null,
                ])
            </form>
        </div>
    </div>
</x-app-layout>
