<!-- default image -->
@isset($data['file']['url'])
    <figure class="editor-js-image-figure">
        <img class="editor-js-image" src="{{$data['file']['url']}}"/>

        <figcaption class="editor-js-image-caption">
            @isset($data['link'])
                <a class="editor-js-image-caption-link" href="{{$data['link']}}">
                    {!!  $data['alt'] ? __('Изображение').' '.$data['alt'] : __('Источник изображения')  !!}
                </a>
            @else
                {!! $data['alt'] ? __('Изображение').' '.$data['alt']: __('Источник изображения') !!}
            @endisset
        </figcaption>
    </figure>
@endisset