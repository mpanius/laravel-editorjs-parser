<figure class="editor-js-image {{ $data['classes'] ?? ' '}}">
    @php
        $imageUrl = $data['file']['url'] ?? null;
        $mediaId = $data['file']['media_id'] ?? $data['media_id'] ?? null;
        $blurhash = $data['file']['bluryhash'] ?? null;
        $originalWidth = $data['file']['width'] ?? null;
        $originalHeight = $data['file']['height'] ?? null;
        // Если есть media_id, но нет URL, попробуем получить URL из медиабиблиотеки

        if(!($imageUrl && $mediaId && $blurhash && $originalHeight && $originalWidth))
            if ($media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId)) {
                $imageUrl = $imageUrl ?? $media->getUrl();
                $blurhash = $blurhash ?? $media->getCustomProperty('blurhash',null);
                $originalWidth = $originalWidth ?? $media->getCustomProperty('width') ?? 0;
                $originalHeight = $originalHeight ?? $media->getCustomProperty('height') ?? 0;
            }




    // Стиль для соотношения сторон и плейсхолдера
    if ($blurhash && $originalWidth && $originalHeight) {

        // Вычисляем соотношение сторон на основе ОРИГИНАЛЬНЫХ размеров
        $aspectRatioStyle = "aspect-ratio: {$originalWidth} / {$originalHeight};";
        // Генерируем стиль фона blurhash с правильным соотношением сторон
        $placeholderStyle = blurhash_style($blurhash, 32, round(32 * $originalHeight / $originalWidth));
        } else {
        $placeholderStyle = ''; $aspectRatioStyle = '';

    }
        // Определяем, является ли изображение маленьким (меньше 400px по ширине)
        $isSmallImage = $originalWidth > 0 && $originalWidth < 400;

        // Максимальная ширина контейнера публикации
        $maxWidth = 920;
        // Максимальная высота изображения на десктопе
        $maxDesktopHeight = 700;

        // Определяем оптимальные размеры для разных устройств
        // Если изображение меньше максимальной ширины, используем его оригинальный размер
        $desktopWidth = $originalWidth > 0 && $originalWidth < $maxWidth ? $originalWidth : $maxWidth;
        $tabletWidth = min(736, $desktopWidth);
        $mobileWidth = min(480, $desktopWidth);

        // Вычисляем соотношение сторон для правильного определения высоты
        $aspectRatio = $originalWidth > 0 && $originalHeight > 0 ? $originalWidth / $originalHeight : 0;

        // Рассчитываем ФИНАЛЬНЫЕ размеры десктопной картинки после preview/W x H
        $finalW = $desktopWidth;
        $finalH = $maxDesktopHeight;
        if ($originalWidth > 0 && $originalHeight > 0 && $aspectRatio > 0) {
            $scaleW = $desktopWidth / $originalWidth;
            $scaleH = $maxDesktopHeight / $originalHeight;
            $scale = min($scaleW, $scaleH);
            $finalW = $originalWidth * $scale;
            $finalH = $originalHeight * $scale;
        }

    @endphp
    @if(!empty($imageUrl))
        <a href="{{normalize($imageUrl)}}" class="glightbox"
           @if($data['caption'] ?? null) data-title="{{$data['caption']}}" @endif>
            <div class="image-container">
                @if(!$isSmallImage)
                    <picture>
                        {{-- Desktop: Limit by both max width and max height --}}
                        <source media="(min-width: 1024px)"
                                srcset="{{ img($imageUrl, $desktopWidth, $maxDesktopHeight) }}">
                        <source media="(min-width: 640px)" srcset="{{ img($imageUrl, $tabletWidth) }}">
                        <img
                                loading="lazy"
                                decoding="async"
                                src="{{ img($imageUrl, $mobileWidth) }}"
                                {{-- Устанавливаем точные размеры самой большой (десктопной) версии для резервирования места --}}
                                width="{{ round($finalW) }}"
                                height="{{ round($finalH) }}"
                                class="block max-w-full h-auto mx-auto"
                                alt="{{ $data['caption'] ?? '' }}"
                                @style(["$placeholderStyle $aspectRatioStyle transition-property: opacity; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 500ms;" => !empty($placeholderStyle) && !empty($aspectRatioStyle),
                                "background-image: url('{{ img($imageUrl, 20) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;" => empty($aspectRatioStyle) && empty($placeholderStyle)])
                                onload="this.style.backgroundImage='none'"
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
                            @if(!empty($data['caption']))
                                alt="{{ $data['caption'] }}"
                            @else
                                alt=""
                            @endif
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
