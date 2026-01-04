@props([
    'value' => 0,
    'max' => 100,
    'variant' => 'primary',
    'striped' => false,
    'animated' => false,
    'label' => true,
])

@php
$percentage = ($max > 0) ? round(($value / $max) * 100) : 0;
$progressClass = "bg-{$variant}";
if ($striped) $progressClass .= ' progress-bar-striped';
if ($animated) $progressClass .= ' progress-bar-animated';
@endphp

<div {{ $attributes->merge(['class' => 'progress']) }}>
    <div 
        class="progress-bar {{ $progressClass }}" 
        role="progressbar" 
        style="width: {{ $percentage }}%;"
        aria-valuenow="{{ $value }}" 
        aria-valuemin="0" 
        aria-valuemax="{{ $max }}"
    >
        @if($label)
            {{ $percentage }}%
        @endif
    </div>
</div>
