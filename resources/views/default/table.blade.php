<table class="editor-js-block editor-js-table">

    @isset($data['caption'])
        <caption class="editor-js-table-caption">{{$data['caption']}}</caption>
    @endisset


    @if($data['withHeadings'] ?? false)
        <thead>
        <tr>
            @foreach ($data['content'][0] as $content)
                <th>
                    {{ $content }}
                </th>
            @endforeach
        </tr>
        </thead>
    @endif
    <tbody>
    @foreach ($data['content'] as $row)
        @if(($data['withHeadings'] ?? false) &&  $loop->first)
        @else

            <tr>
                @foreach ($row as $content)
                    <td>
                        {{ $content }}
                    </td>
                @endforeach
            </tr>
        @endif

    @endforeach
    </tbody>
</table>
