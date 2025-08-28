@php
    $items = data_get($data, 'items', []);
@endphp
@if(!empty($items))
<ul>
    @foreach($items as $item)
        @php
            $content = is_string($item) ? $item : data_get($item, 'text', data_get($item, 'content', ''));
            $checked = (bool) data_get($item, 'checked', data_get($item, 'meta.checked', false));
        @endphp
        <li>{!! $checked ? '☑' : '☐' !!} {!! $content !!}</li>
    @endforeach
</ul>
@endif
