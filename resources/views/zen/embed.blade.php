@php
    $service = (string) data_get($data, 'service', '');
    $embed   = (string) data_get($data, 'embed', '');
    $source  = (string) (data_get($data, 'source', data_get($data, 'url', $embed)));
    $caption = trim((string) data_get($data, 'caption', ''));
    $width   = (int) (data_get($data, 'width', 560));
    $height  = (int) (data_get($data, 'height', 315));
@endphp

@if($service === 'youtube' && $embed)
    <div class="video">
        <iframe
            src="{{ $embed }}"
            width="{{ $width }}"
            height="{{ $height }}"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    </div>
    @if($caption !== '')
        <p>{{ $caption }}</p>
    @endif
@elseif($source)
    <p><a href="{{ $source }}">{{ $caption !== '' ? $caption : $source }}</a></p>
@endif

