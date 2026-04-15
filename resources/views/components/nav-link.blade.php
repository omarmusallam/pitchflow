@props(['active'])

@php
    $isActive = $active ?? false;

    $classes = $isActive
        ? 'inline-flex items-center rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-900 bg-slate-100 shadow-sm ring-1 ring-slate-200/80 transition'
        : 'inline-flex items-center rounded-2xl px-4 py-2.5 text-sm font-medium text-slate-500 transition hover:bg-slate-50 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
