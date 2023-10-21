<!-- default quote -->
@isset($data['text'])
    <blockquote class="editor-js-blockquote" @isset($cite) cite="{{$cite}}" @endisset>
        {{$data['text']}}
    </blockquote>
    @isset($data['caption'])<strong>{{$data['caption']}}</strong>@endisset
@endisset


