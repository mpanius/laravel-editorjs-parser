<!-- default quote -->
@isset($data['text'])
    <blockquote class="editor-js-blockquote">
        <p>{{$data['text']}}</p>
        @isset($data['caption'])<b>&nbsp;—&nbsp;{{$data['caption']}}</b>@endisset
    </blockquote>

@endisset


