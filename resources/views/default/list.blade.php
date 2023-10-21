@if($data['style']  === 'unordered')

    <ul class="editor-js-list editor-js-list-unordered">

        @foreach ($data['items'] as $item)
            <li class="editor-js-unordered-list-element">
                {!! $item !!}
            </li>
        @endforeach
    </ul>

@else

    <ol class="editor-js-list editor-js-list-ordered">

        @foreach ($data['items'] as $item)
            <li class="editor-js-ordered-list-element">
                {!! $item !!}
            </li>
        @endforeach
    </ol>

@endif

