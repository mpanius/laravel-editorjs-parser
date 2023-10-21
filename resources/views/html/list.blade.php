<div class="mx-auto">
    @if($data['style']  === 'unordered')

        <ul class="list-disc">

            @foreach ($data['items'] as $item)
                <li>
                    {!! $item !!}
                </li>
            @endforeach
        </ul>

    @else

        <ol class="list-decimal">

            @foreach ($data['items'] as $item)
                <li>
                    {!! $item !!}
                </li>
            @endforeach
        </ol>

    @endif
</div>

