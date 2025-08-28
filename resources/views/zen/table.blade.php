@php
    $rows = (array) data_get($data, 'content', []);
    $withHeadings = (bool) data_get($data, 'withHeadings', false);
    $headers = [];
    if ($withHeadings && count($rows)) {
        $headers = array_shift($rows);
    }
@endphp
@if(!empty($rows))
    @foreach($rows as $r)
        @php($cells = (array) $r)
        @if(!empty($headers))
            <ul>
                @foreach($cells as $i => $cell)
                    <li><b>{!! data_get($headers, $i, '—') !!}</b>: {!! $cell !!}</li>
                @endforeach
            </ul>
        @else
            <p>{!! implode(' — ', $cells) !!}</p>
        @endif
    @endforeach
@endif
