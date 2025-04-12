<figure class="editor-js-image {{ $data['classes'] ?? ' '}}">
    @php
        $imageUrl = $data['file']['url'] ?? '';
        $mediaId = $data['file']['media_id'] ?? null;
        
        // Если есть media_id, но нет URL, попробуем получить URL из медиабиблиотеки
        if (!$imageUrl && $mediaId) {
            // Пытаемся найти медиа по ID
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId);
            if ($media) {
                $imageUrl = $media->getUrl();
            }
        }
        
        // Проверяем, что у нас есть URL изображения
        if (empty($imageUrl)) {
            $imageUrl = ''; // Обеспечиваем, что переменная будет определена даже если URL отсутствует
        }
        
        // Получаем размеры изображения
        $originalWidth = $data['file']['width'] ?? 0;
        $originalHeight = $data['file']['height'] ?? 0;
        
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

        // Вычисляем высоту для самой большой версии изображения (desktop), чтобы задать правильные размеры тегу img
        $desktopHeight = $aspectRatio > 0 ? round($desktopWidth / $aspectRatio) : 0;
    @endphp
    @if(!empty($imageUrl))
    <a href="{{normalize($imageUrl)}}" class="glightbox"
       @if($data['caption'] ?? null) data-title="{{$data['caption']}}" @endif>
        <div class="image-container" @if($aspectRatio > 0) style="aspect-ratio: {{ $aspectRatio }}" @endif>
            @if(!$isSmallImage)
                <picture>
                    {{-- Desktop: Limit by both max width and max height --}}
                    <source media="(min-width: 1024px)" srcset="{{ img($imageUrl, $desktopWidth, $maxDesktopHeight) }}">
                    <source media="(min-width: 640px)" srcset="{{ img($imageUrl, $tabletWidth) }}">
                    <img 
                        loading="lazy"
                        decoding="async"
                        src="{{ img($imageUrl, $mobileWidth) }}"
                        @if($originalWidth > 0 && $originalHeight > 0)
                            {{-- Use dimensions of the largest image requested in srcset to prevent browser upscaling --}}
                            width="{{ $desktopWidth }}"
                            height="{{ $desktopHeight }}"
                        @endif
                        @if(!empty($data['caption']))
                            alt="{{ $data['caption'] }}"
                        @else
                            alt=""
                        @endif
                        class="w-full h-auto"
                        style="background-image: url('{{ img($imageUrl, 20) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                        onload="this.style.backgroundImage='none'"
                    >
                </picture>
            @else
                {{-- Для маленьких изображений не используем responsive loading --}}
                <img 
                    decoding="async"
                    src="{{ img($imageUrl, $originalWidth) }}"
                    @if($originalWidth > 0 && $originalHeight > 0)
                        width="{{ $originalWidth }}"
                        height="{{ $originalHeight }}"
                    @endif
                    @if(!empty($data['caption']))
                        alt="{{ $data['caption'] }}"
                    @else
                        alt=""
                    @endif
                    class="w-full h-auto"
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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="w-3 h-3 inline">
                            <path fill-rule="evenodd"
                                  d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z"
                                  clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                  d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z"
                                  clip-rule="evenodd" />
                        </svg>
                        {{ $data['alt'] ? __('Изображение').' '.$data['alt']: __('Источник изображения') }}</a></div>
            @endif</figcaption>
    @endif
</figure>
