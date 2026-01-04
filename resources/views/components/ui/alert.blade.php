@props([
    'type' => 'info', // info, success, warning, danger
    'dismissible' => false,
    'icon' => true,
])

@php
$classes = [
    'info' => 'alert-info',
    'success' => 'alert-success',
    'warning' => 'alert-warning',
    'danger' => 'alert-danger',
];

$icons = [
    'info' => 'fa-circle-info',
    'success' => 'fa-circle-check',
    'warning' => 'fa-triangle-exclamation',
    'danger' => 'fa-circle-xmark',
];

$alertClass = $classes[$type] ?? $classes['info'];
$iconClass = $icons[$type] ?? $icons['info'];
@endphp

<div {{ $attributes->merge(['class' => "alert {$alertClass}" . ($dismissible ? ' alert-dismissible fade show' : '')]) }} role="alert">
    @if($icon)
        <i class="fas {{ $iconClass }} me-2"></i>
    @endif
    
    {{ $slot }}
    
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
