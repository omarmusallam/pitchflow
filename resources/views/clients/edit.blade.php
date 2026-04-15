<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-slate-500">Client management</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Edit Client
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Update client details and keep your workspace data clean.
            </p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="{{ route('clients.update', $client) }}" method="POST">
                @csrf
                @method('PUT')

                @include('clients._form', ['submitLabel' => 'Update Client'])
            </form>
        </div>
    </div>
</x-app-layout>
