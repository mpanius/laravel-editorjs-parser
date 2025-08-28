@php
    $code = (string) data_get($data, 'code', '');
    $lines = preg_split("/(\r\n|\r|\n)/", $code);
@endphp
@foreach($lines as $line)
<blockquote>{{ $line }}</blockquote>
@endforeach
