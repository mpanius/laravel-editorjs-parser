{{-- AMP Checklist (rendered as simple list) --}}
<ul class="editor-js-list list-disc pl-5">
    @foreach($data['items'] ?? [] as $item)
        <li class="mb-1">{!! $item['text'] !!} {{-- Assuming structure like checklist --}}</li>
    @endforeach
</ul>
