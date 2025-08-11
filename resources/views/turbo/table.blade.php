@php($rows = $data['content'] ?? [])
<table>
    @if(($data['withHeadings'] ?? false) && count($rows) > 0)
        <thead>
        <tr>
            @foreach ($rows[0] as $cell)
                <th>{{ $cell }}</th>
            @endforeach
        </tr>
        </thead>
        @if(count($rows) > 1)
            <tbody>
            @foreach (array_slice($rows, 1) as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        @endif
    @else
        <tbody>
        @foreach ($rows as $row)
            <tr>
                @foreach ($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    @endif
</table>