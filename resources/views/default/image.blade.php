@php
    $mediaId = $data['file']['media_id'] ?? $data['media_id'] ?? null;
    $media = media($mediaId);

    if(empty($media)) return '';

    $imageUrl = $media->getFullUrl() ?? null;
    $placeholderStyle  =  $media->blurhash_style ??null;
    $originalWidth = $media->width ?? $media->getCustomProperty('width') ?? 0;
    $originalHeight = $media->height ?? $media->getCustomProperty('height') ?? 0;


       // Определяем, является ли изображение маленьким (меньше 400px по ширине)
       $isSmallImage = $originalWidth > 0 && $originalWidth < 400;

       // Максимальная ширина контейнера публикации
       $maxWidth = 920;
       // Максимальная высота изображения на десктопе
       $maxDesktopHeight = 700;

       // Определяем оптимальные размеры для разных устройств
       // Если изображение меньше максимальной ширины, используем его оригинальный размер
       $desktopWidth = (($originalWidth > 0) && ($originalWidth < $maxWidth)) ? $originalWidth : $maxWidth;
       $tabletWidth = min(736, $desktopWidth);
       $mobileWidth = min(480, $desktopWidth);

       // Вычисляем соотношение сторон для правильного определения высоты
       $aspectRatio = (($originalWidth > 0) && ($originalHeight > 0)) ? $originalWidth / $originalHeight : 0;

       // Рассчитываем ФИНАЛЬНЫЕ размеры десктопной картинки после preview/W x H
       $finalW = $desktopWidth;
       $finalH = $maxDesktopHeight;
       if (($originalWidth > 0) && ($originalHeight > 0) && ($aspectRatio > 0)) {
           $scaleW = $desktopWidth / $originalWidth;
           $scaleH = $maxDesktopHeight / $originalHeight;
           $scale = min($scaleW, $scaleH);
           $finalW = $originalWidth * $scale;
           $finalH = $originalHeight * $scale;
       }

@endphp
<figure class="editor-js-image {{ $data['classes'] ?? ' '}}">
    @if(!empty($imageUrl))
        <a href="{{ (($originalWidth > 0) && ($originalWidth < 3000)) ? img($imageUrl,$originalWidth) : img($imageUrl,3000)}}"
           class="glightbox"
           data-original-width="{{$originalWidth}}"
           data-original-height="{{$originalHeight}}"
           data-download-link="{{$imageUrl}}"
           @if($data['caption'] ?? null) data-title="{{$data['caption']}}" @endif>
            <div class="image-container">
                @if(!$isSmallImage)
                    <picture>
                        {{-- Desktop: Limit by both max width and max height --}}
                        <source media="(min-width: 1024px)"
                                srcset="{{ img($imageUrl, $desktopWidth, $maxDesktopHeight) }}">
                        <source media="(min-width: 640px)" srcset="{{ img($imageUrl, $tabletWidth) }}">
                        <img

                                src="{{ img($imageUrl, $mobileWidth) }}"
                                {{-- Устанавливаем точные размеры самой большой (десктопной) версии для резервирования места --}}
                                width="{{ round($finalW) }}"
                                height="{{ round($finalH) }}"
                                class="block max-w-full h-auto mx-auto"
                                alt="{{ $data['caption'] ?? '' }}"
                                @style(["$placeholderStyle;" => !empty($placeholderStyle),
                                "aspect-ratio: $originalWidth / $originalHeight;" => $originalWidth > 0 && $originalHeight > 0])

                        >
                    </picture>
                @else
                    {{-- Small image: display directly, centered --}}
                    <img
                            loading="lazy"
                            decoding="async"
                            src="{{ img($imageUrl, $mobileWidth) }}"
                            width="{{ $originalWidth }}"
                            height="{{ $originalHeight }}"
                            alt="{{ $data['caption'] ?? '' }}"
                            class="block max-w-full h-auto mx-auto"
                    >
                @endif
            </div>
        </a>
    @endif
    @if (($data['caption'] ?? null) || ($data['alt'] ?? null) || ($data['link'] ?? null) )
        <figcaption class="mx-auto text-center ">
            <span>{{ $data['caption'] ?? ''}}</span>
            @if($data['link'] ?? null)
                <div class="text-xs @if(!empty($data['caption'] ?? null))mt-2 @endif"><a target="_blank"
                                                                                         class="no-underline text-gray-500 hover:text-blue-500"
                                                                                         href="{{$data['link']}}">
                        {{ $data['alt'] ? __('Изображение').' '.$data['alt']: __('Источник изображения') }}</a></div>
            @endif
        </figcaption>
    @endif
</figure>
