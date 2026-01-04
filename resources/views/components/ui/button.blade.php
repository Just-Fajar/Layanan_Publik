@props([
    'variant' => 'primary', // primary, secondary, success, danger, warning, info
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'icon' => null,
    'loading' => false,
    'outline' => false,
])

@php
$sizeClasses = [
    'sm' => 'btn-sm',
    'md' => '',
    'lg' => 'btn-lg',
];

$variantClass = $outline ? "btn-outline-{$variant}" : "btn-{$variant}";
$sizeClass = $sizeClasses[$size] ?? '';
@endphp

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => "btn {$variantClass} {$sizeClass}"]) }}
    @if($loading) disabled @endif
>
    @if($loading)
        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
    @elseif($icon)
        <i class="fas {{ $icon }} me-1"></i>
    @endif
    
    {{ $slot }}
</button>
