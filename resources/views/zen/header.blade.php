@php
    $level = (int) data_get($data, 'level', 2);
    $level = $level < 1 ? 1 : ($level > 4 ? 4 : $level);
    $text = (string) data_get($data, 'text', '');
@endphp
@if($level === 1)
<h1>{!! $text !!}</h1>
@elseif($level === 2)
<h2>{!! $text !!}</h2>
@elseif($level === 3)
<h3>{!! $text !!}</h3>
@else
<h4>{!! $text !!}</h4>
@endif
