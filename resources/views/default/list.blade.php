<div class="mx-auto max-w-4xl px-4">

    @if($data['style']  === 'unordered')

        <ul class="list-disc">

            @foreach ($data['items'] as $item)
                <li>
                    {!! is_string($item) ? $item : data_get($item,'content') !!}
                </li>
            @endforeach
        </ul>

    @else

        <ol class="list-decimal">

            @foreach ($data['items'] as $item)
                <li>
                        {!! is_string($item) ? $item : data_get($item,'content') !!}
                </li>
            @endforeach
        </ol>

    @endif
</div>

