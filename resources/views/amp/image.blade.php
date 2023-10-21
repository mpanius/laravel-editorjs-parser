<div class="editor-js-block my-6">

    <figure class="editor-js-image{{ $data['classes'] ?? ' '}}">


            <amp-img layout="responsive" @if(!empty($data['file']['width']) && $data['file']['width'] != 0)width="{{$data['file']['width']}}"
                 height="{{$data['file']['height']}}" @endif
                 src="{{ $data['file']['url']}}" @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif>

        @if (($data['caption'] ?? null) || ($data['source'] ?? null))
            <figcaption class="prose prose-2xl my-2 mx-auto text-center"><span>{{ $data['caption'] ?? ''}}</span><span>{{ $data['source'] ?? '' }}</span></figcaption>
        @endif
    </figure>
</div>
