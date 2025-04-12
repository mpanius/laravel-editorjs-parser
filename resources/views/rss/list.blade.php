{{-- RSS List --}}
@php
    $items = $data['items'] ?? [];
    $style = $data['style'] ?? 'unordered'; // 'unordered' or 'ordered'
@endphp

@if(!empty($items))
    @foreach($items as $index => $item)
        @if($style === 'ordered')
            {{ $index + 1 }}. {!! $item !!}<br>
        @else
            — {!! $item !!}<br>
        @endif
    @endforeach
    <br>
@endif
