<!-- default quote -->
@isset($data['text'])
    <blockquote class="editor-js-blockquote">
        <span>{{$data['text']}}</span>
        @isset($data['caption'])<span><b>&nbsp;—&nbsp;{{$data['caption']}}</b></span>@endisset
    </blockquote>

@endisset


