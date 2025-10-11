@php

    $hasSet = true;
    $isSmall = ($data['originalWidth'] < $data['maxDeskWidth']) || ($data['originalHeight'] < $data['maxDeskHeight']);
@endphp
<figure @class(['editor-js-image','image-stretched' => $data['stretched'] ?? false, 'image-with-border' => $data['withBorder'], 'image-with-background' => $data['withBackground'] ?? false])>
    @if(!$isSmall)
        <a href="{{img($data['imageUrl'],$data['originalWidth'],$data['originalHeight'],false)}}"
           class="glightbox _gallery resize-image"
           data-original-width="{{$data['originalWidth']}}"
           data-original-height="{{$data['originalHeight']}}"
           data-download-link="{{$data['imageUrl']}}"
           @if($data['caption'] ?? null) data-title="{{$data['caption']}}" @endif>

            <div class="image-container">
                <img
                        loading="lazy"
                        decoding="async"
                        src="{{img($data['imageUrl'],$data['width'],$data['height'],false)}}"
                        data-resizewidth="{{$data['width']}}"
                        data-resizeheight="{{$data['height']}}"
                        class="block max-w-full h-auto mx-auto"
                        alt="{{$data['caption'] ?? ''}}"

                        width="{{ $data['width'] }}"
                        height="{{ ($data['width']/$data['originalWidth'] )* $data['originalHeight'] }}"
                        style="aspect-ratio: {{ $data['originalWidth'] }} / {{ $data['originalHeight'] }};"

                        srcset="
                        @foreach($data['srcSet'] as $width)
                        @if($data['originalWidth'] > $width) {{ img(url: $data['imageUrl'], width:$width) }} {{$width}}w, @endif @endforeach
                        {{ img(url: $data['imageUrl'], width:$data['originalWidth'])}} {{$data['originalWidth']}}w"
                sizes="{{$data['srcSizes']}}"
                />
            </div>
        </a>
    @else
        <div>
            <div class="image-container">
                <img
                        loading="lazy"
                        decoding="async"
                        src="{{img($data['imageUrl'],$data['width'],$data['height'],false)}}"
                        width="{{ $data['originalWidth'] }}"
                        height="{{ $data['originalHeight'] }}"
                        class="block max-w-full h-auto mx-auto"
                        alt="{{$data['caption'] ?? ''}}"
                        style="aspect-ratio: {{$data['originalWidth']}} / {{$data['originalHeight']}};"
                        srcset="@foreach($data['srcSet'] as $width)
                            @if(($data['originalWidth'] > $width)) {{ img(url: $data['imageUrl'], width:$width)}} {{$width}}w, @endif @endforeach
                            {{ img(url: $data['imageUrl'], width:$data['originalWidth'])}} {{$data['originalWidth']}}w"
                            sizes="{{$data['srcSizes']}}"

                />
            </div>
            @endif
            @if (($data['caption'] ?? null) || ($data['alt'] ?? null) || ($data['link'] ?? null) )
                <figcaption class="mx-auto text-center ">
                    <span>{{ ($data['caption'] ?? false) ? html_entity_decode($data['caption']) : ''}}</span>
                    @if($data['link'] ?? null)
                        <div class="text-xs @if(!empty($data['caption'] ?? null))mt-2 @endif"><a target="_blank"
                                                                                                 class="no-underline text-gray-500 hover:text-blue-500"
                                                                                                 href="{{str_replace('&nbsp;','',$data['link'])}}">
                                {{ ($data['alt'] ?? false) ? __('Image source').' '. html_entity_decode($data['alt']): __('Image source') }}</a>
                        </div>
                    @endif
                </figcaption>
    @endif
</figure>
