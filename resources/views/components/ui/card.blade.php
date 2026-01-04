@props([
    'title' => null,
    'image' => null,
    'imageAlt' => '',
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'card h-100']) }}>
    @if($image)
        <img src="{{ $image }}" class="card-img-top" alt="{{ $imageAlt }}">
    @endif
    
    <div class="card-body">
        @if($title)
            <h5 class="card-title">{{ $title }}</h5>
        @endif
        
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
