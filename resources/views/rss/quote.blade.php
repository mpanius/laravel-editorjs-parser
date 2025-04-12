{{-- RSS Quote --}}
@php
    $text = $data['text'] ?? '';
    $caption = $data['caption'] ?? ''; // Author
    $alignment = $data['alignment'] ?? 'left';
@endphp

@if($text)
    " {!! $text !!} "<br>
    @if($caption)
        — {!! $caption !!}
    @endif
    <br><br>
@endif
