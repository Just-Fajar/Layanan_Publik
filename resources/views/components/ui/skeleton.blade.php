@props([
    'count' => 3, // Number of skeleton items
    'type' => 'card', // card, list, table
])

<div {{ $attributes->merge(['class' => 'skeleton-loader']) }}>
    @if($type === 'card')
        <div class="row g-3">
            @for($i = 0; $i < $count; $i++)
                <div class="col-md-4">
                    <div class="card">
                        <div class="skeleton-image" style="height: 200px;"></div>
                        <div class="card-body">
                            <div class="skeleton-text mb-2" style="width: 80%;"></div>
                            <div class="skeleton-text mb-2" style="width: 60%;"></div>
                            <div class="skeleton-text" style="width: 40%;"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    @elseif($type === 'list')
        @for($i = 0; $i < $count; $i++)
            <div class="list-group-item">
                <div class="d-flex gap-3">
                    <div class="skeleton-circle" style="width: 48px; height: 48px;"></div>
                    <div class="flex-grow-1">
                        <div class="skeleton-text mb-2" style="width: 70%;"></div>
                        <div class="skeleton-text" style="width: 50%;"></div>
                    </div>
                </div>
            </div>
        @endfor
    @elseif($type === 'table')
        <table class="table">
            <thead>
                <tr>
                    @for($col = 0; $col < 4; $col++)
                        <th><div class="skeleton-text"></div></th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @for($row = 0; $row < $count; $row++)
                    <tr>
                        @for($col = 0; $col < 4; $col++)
                            <td><div class="skeleton-text"></div></td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    @endif
</div>

<style>
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

.skeleton-loader {
    animation: pulse 1.5s ease-in-out infinite;
}

.skeleton-text,
.skeleton-image,
.skeleton-circle {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
    border-radius: 4px;
    height: 1em;
    margin-bottom: 0.5em;
}

.skeleton-image {
    height: 200px;
    width: 100%;
}

.skeleton-circle {
    border-radius: 50%;
}
</style>
