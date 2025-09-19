@if($data['style'] === 'checklist')
    <ul class="checklist">
        @foreach ($data['items'] as $item)
            <li>
                @php
                    $content = is_string($item) ? $item : data_get($item, 'content');
                    $isChecked = data_get($item, 'meta.checked', false);
                @endphp
                <input type="checkbox" {{ $isChecked ? 'checked' : '' }} disabled>
                <span>{!! $content !!}</span>
            </li>
        @endforeach
    </ul>
@elseif($data['style'] === 'unordered')
    <ul class="list-disc">
        @foreach ($data['items'] as $item)
            <li>
                @php
                    $content = is_string($item) ? $item : data_get($item, 'content');
                    $nestedItems = data_get($item, 'items', []);
                @endphp
                {!! $content !!}

                @if(!empty($nestedItems))
                    <ul class="list-disc ml-6">
                        @foreach($nestedItems as $nestedItem)
                            <li>{!! is_string($nestedItem) ? $nestedItem : data_get($nestedItem, 'content') !!}</li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
@else
    <ol class="list-decimal">
        @foreach ($data['items'] as $item)
            <li>
                @php
                    $content = is_string($item) ? $item : data_get($item, 'content');
                    $nestedItems = data_get($item, 'items', []);
                @endphp
                {!! $content !!}

                @if(!empty($nestedItems))
                    <ol class="list-decimal ml-6">
                        @foreach($nestedItems as $nestedItem)
                            <li>{!! is_string($nestedItem) ? $nestedItem : data_get($nestedItem, 'content') !!}</li>
                        @endforeach
                    </ol>
                @endif
            </li>
        @endforeach
    </ol>
@endif
