@php

    $hasSet = true;
@endphp
<figure @class(['image-stretched' => $data['stretched'] ?? false, 'image-with-border' => $data['withBorder'], 'image-with-background' => $data['withBackground'] ?? false])>
    <img
            loading="lazy"
            decoding="async"
            class="content-image dynamic-lightbox"
            @isset($data['originalWidth'])
            width="{{$data['originalWidth']}}"
            height="{{$data['originalHeight']}}"
            style="aspect-ratio: {{$data['originalWidth']}} / {{$data['originalHeight']}};"
            src="{{img($data['imageUrl'],$data['width'],$data['height'],false)}}"
            srcset="
            @foreach($data['srcSet'] as $width)
            @if($hasSet && ($data['originalWidth'] > $width))
            {{img(url: $data['imageUrl'], width:$width)}} {{$width}}w,
            @elseif($hasSet)
              @php $hasSet = false; @endphp
              {{img(url: $data['imageUrl'], width:$data['originalWidth'])}} {{$data['originalWidth']}}w
            @else @break  @endif @endforeach"
            sizes="{{$data['srcSizes']}}"
            @endisset

            alt="{{$data['caption'] ?? ''}}"
    />
    @if (($data['caption'] ?? null) || ($data['alt'] ?? null) || ($data['link'] ?? null) )
        <figcaption class="mx-auto text-center ">
            <span>{{ ($data['caption'] ?? false) ? htmlspecialchars_decode($data['caption']) : ''}}</span>
            @if($data['link'] ?? null)
                <div class="text-xs @if(!empty($data['caption'] ?? null))mt-2 @endif"><a target="_blank"
                                                                                         class="no-underline text-gray-500 hover:text-blue-500"
                                                                                         href="{{$data['link']}}">
                        {{ ($data['alt'] ?? false) ? __('Изображение').' '. htmlspecialchars_decode($data['alt']): __('Источник изображения') }}</a></div>
            @endif
        </figcaption>
    @endif
</figure>
