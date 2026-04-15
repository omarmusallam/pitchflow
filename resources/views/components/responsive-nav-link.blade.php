@props(['active'])

@php
    $isActive = $active ?? false;

    $classes = $isActive
        ? 'block rounded-2xl bg-slate-100 px-4 py-3 text-base font-semibold text-slate-900 shadow-sm ring-1 ring-slate-200/80 transition'
        : 'block rounded-2xl px-4 py-3 text-base font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
