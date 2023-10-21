<div class="editor-js-block">
    <figure class="editor-js-quote">
        <blockquote class="bg-gray-100 prose">
            <p class="editor-js-quote-text  p-2" style="text-align: {{$data['alignment'] ?? ''}}">
                {{$data['text'] ?? ''}}
            </p>
            @if(!empty($data['caption']))
                <figcaption class="editor-js-quote-caption bg-gray-200 p-2">
                    {{$data['caption']}}
                </figcaption>
            @endif

        </blockquote>
    </figure>
</div>
