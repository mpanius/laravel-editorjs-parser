<table class="editor-js-table table-auto border-collapse w-full text-sm rounded-xl not-prose border">
    @if($data['withHeadings'] ?? false)
        @foreach ($data['content'] as $row)
            @if($loop->index === 0)

                <tr class="bg-slate-50">
                    @foreach ($row as $content)
                        <th class="border-b dark:border-slate-600 font-medium p-4 text-slate-400 dark:text-slate-200">
                            {{ $content }}
                        </th>
                    @endforeach
                </tr>

            @else
                <tr>
                    @foreach ($row as $content)
                        <td class="border-b dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                            {{ $content }}
                        </td>
                    @endforeach
                </tr>

            @endif
        @endforeach

    @else
        <tbody>
        @foreach ($data['content'] as $row)
            <tr>
                @foreach ($row as $content)
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                        {{ $content }}
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    @endif
</table>
