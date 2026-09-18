@props(['status'])

@php
    $classes = match($status) {
        'Aman' => 'bg-green-100 text-green-800',
        'Menipis' => 'bg-yellow-100 text-yellow-800',
        'Habis' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex px-2 rounded-full text-xs font-semibold ' . $classes]) }}>
    {{ $slot }}
</span>
