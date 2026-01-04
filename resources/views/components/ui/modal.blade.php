@props([
    'show' => false,
    'title' => '',
    'size' => 'md', // sm, md, lg, xl
    'centered' => false,
    'scrollable' => false,
])

@php
$sizeClasses = [
    'sm' => 'modal-sm',
    'md' => '',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
];

$modalDialogClass = $sizeClasses[$size] ?? '';
if ($centered) $modalDialogClass .= ' modal-dialog-centered';
if ($scrollable) $modalDialogClass .= ' modal-dialog-scrollable';
@endphp

<div 
    {{ $attributes->merge(['class' => 'modal fade']) }}
    tabindex="-1"
    aria-labelledby="{{ $attributes->get('id') }}Label"
    aria-hidden="true"
>
    <div class="modal-dialog {{ $modalDialogClass }}">
        <div class="modal-content">
            @if($title)
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $attributes->get('id') }}Label">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="modal-body">
                {{ $slot }}
            </div>
            
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
