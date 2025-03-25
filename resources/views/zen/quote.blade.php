<!-- default quote -->
@isset($data['text'])
    <blockquote class="editor-js-blockquote">
        <span>{{strip_tags($data['text'],['<a>'])}}</span>
        @isset($data['caption'])
            <span><br /><b>&nbsp;—&nbsp;{{$data['caption']}}</b></span>
        @endisset
    </blockquote>

@endisset


