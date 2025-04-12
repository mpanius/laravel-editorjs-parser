{{-- AMP Table --}}
<div class="overflow-x-auto">
    <table class="editor-js-table w-full border-collapse border border-gray-300">
        @if(!empty($data['withHeadings']))
            <thead>
                <tr>
                    @foreach($data['content'][0] ?? [] as $cell)
                        <th class="border border-gray-300 p-2 bg-gray-100 text-left">{!! $cell !!}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach(array_slice($data['content'], 1) as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td class="border border-gray-300 p-2">{!! $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        @else
            <tbody>
                @foreach($data['content'] as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td class="border border-gray-300 p-2">{!! $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
</div>
