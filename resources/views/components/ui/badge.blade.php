@props([
    'color' => 'primary',
    'pill' => false,
])

@php
$badgeClass = "badge bg-{$color}";
if ($pill) $badgeClass .= ' rounded-pill';
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    {{ $slot }}
</span>
