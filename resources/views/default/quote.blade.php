<!-- default quote -->
@isset($data['text'])
    <blockquote class="editor-js-blockquote">
        {{$data['text']}}
        @isset($data['caption'])<footer>{{$data['caption']}}</footer>@endisset
    </blockquote>

@endisset


