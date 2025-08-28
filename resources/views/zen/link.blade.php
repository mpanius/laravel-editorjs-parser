@php
    $url = (string) data_get($data, 'link', data_get($data, 'url', ''));
    $title = (string) data_get($data, 'title', $url);
    $caption = (string) data_get($data, 'caption', '');
@endphp
@if($url)
<p><a href="{{ $url }}">{!! $title !!}</a>@if($caption) — {!! $caption !!}@endif</p>
@endif
