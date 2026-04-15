<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-slate-500">Proposal management</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Edit Proposal
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Update proposal details, status, and financial summary.
            </p>
        </div>
    </x-slot>

    <div class="max-w-5xl">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="{{ route('proposals.update', $proposal) }}" method="POST">
                @csrf
                @method('PUT')

                @include('proposals._form', ['submitLabel' => 'Update Proposal'])
            </form>
        </div>
    </div>
</x-app-layout>
