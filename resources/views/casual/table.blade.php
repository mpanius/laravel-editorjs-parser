<div class="editor-js-table-container relative overflow-x-auto">
    <table class="editor-js-table table-auto w-full border">
        @php($rows = $data['content'] ?? [])
        @if(($data['withHeadings'] ?? false) && count($rows) > 0)
            <thead>
            <tr class="bg-slate-50">
                @foreach ($rows[0] as $content)
                    <th class="border-b dark:border-slate-600 font-medium p-4 text-slate-400 dark:text-slate-200">
                        {{ $content }}
                    </th>
                @endforeach
            </tr>
            </thead>
            @if(count($rows) > 1)
                <tbody>
                @foreach (array_slice($rows, 1) as $row)
                    <tr>
                        @foreach ($row as $content)
                            <td class="border-b dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                                {{ $content }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            @endif
        @else
            <tbody>
            @foreach ($rows as $row)
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
    </div>