@php
    $dimensions = $dimensions ?? null;
    if (!$dimensions) {
        return '';
    }
@endphp
<figure class="editor-js-image {{ $data['classes'] ?? ' '}}">
    @if(!empty($dimensions['fullImageUrl']))
        <a href="{{ (($dimensions['originalWidth'] > 0) && ($dimensions['originalWidth'] < 3000)) ? img($dimensions['fullImageUrl'], $dimensions['originalWidth']) : img($dimensions['fullImageUrl'], 3000)}}"
           class="glightbox _gallery resize-image"
           data-original-width="{{$dimensions['originalWidth']}}"
           data-original-height="{{$dimensions['originalHeight']}}"
           data-download-link="{{$dimensions['fullImageUrl']}}"
           @if($data['caption'] ?? null) data-title="{{$data['caption']}}" @endif>
            <div class="image-container">
                @if(!$dimensions['isSmallImage'])
                        <img
                                data-resizewidth="{{$dimensions['desktopWidth']}}"
                                data-resizeheight="{{$dimensions['maxDesktopHeight']}}"
                                src="{{ $dimensions['imageUrl'] }}"
                                {{-- Устанавливаем точные размеры самой большой (десктопной) версии для резервирования места --}}
                                width="{{ $dimensions['finalWidth'] }}"
                                height="{{ $dimensions['finalHeight'] }}"
                                class="block max-w-full h-auto mx-auto"
                                alt="{{ $data['caption'] ?? '' }}"
                                @style([ "aspect-ratio: {$dimensions['originalWidth']} / {$dimensions['originalHeight']};" => $dimensions['originalWidth'] > 0 && $dimensions['originalHeight'] > 0])
                        >
                @else
                    {{-- Small image: display directly, centered --}}
                    <img
                            loading="lazy"
                            decoding="async"
                            data-resizewidth="{{$dimensions['desktopWidth']}}"
                            data-resizeheight="{{$dimensions['maxDesktopHeight']}}"
                            src="{{ $dimensions['imageUrl'] }}"
                            width="{{ $dimensions['originalWidth'] }}"
                            height="{{ $dimensions['originalHeight'] }}"
                            alt="{{ $data['caption'] ?? '' }}"
                            class="block max-w-full h-auto mx-auto"
                    >
                @endif
            </div>
        </a>
    @endif
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