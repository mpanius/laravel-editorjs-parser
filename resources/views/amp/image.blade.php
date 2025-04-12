<div class="editor-js-block my-6">
    @php
        use Illuminate\Support\Str;

        // Ensure 'file' data is valid before proceeding
        $fileData = isset($data['file']) && is_array($data['file']) ? $data['file'] : null;

        $imageUrl = $fileData['url'] ?? '';
        $mediaId = $fileData['media_id'] ?? null;

        // Если есть media_id, но нет URL, попробуем получить URL из медиабиблиотеки
        if (!$imageUrl && $mediaId) {
            // Пытаемся найти медиа по ID
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId);
            if ($media) {
                $imageUrl = $media->getUrl();
            }
        }

        // --- Расчет размеров для AMP --- 
        $originalWidth = $fileData['width'] ?? 0;
        $originalHeight = $fileData['height'] ?? 0;

        // --- Настройки размеров (можно вынести в конфиг) ---
        $maxWidth = 920; // Максимальная ширина контента
        $maxDesktopHeight = 700; // Максимальная высота для десктопа
        // ---------------------------------------------

        // Определение ширины для запроса к CDN
        $desktopWidth = $originalWidth > 0 && $originalWidth < $maxWidth ? $originalWidth : $maxWidth;

        // Рассчитываем ФИНАЛЬНЫЕ размеры десктопной картинки после preview/W x H для атрибутов width/height
        $finalW = $desktopWidth;
        $finalH = $maxDesktopHeight;
        if ($originalWidth > 0 && $originalHeight > 0) {
            $aspectRatio = $originalWidth / $originalHeight;
            $scaleW = $desktopWidth / $originalWidth;
            $scaleH = $maxDesktopHeight / $originalHeight;
            $scale = min($scaleW, $scaleH);
            $finalW = $originalWidth * $scale;
            $finalH = $originalHeight * $scale;
        }
        // Убедимся, что размеры не нулевые для AMP
        $finalW = max(1, $finalW);
        $finalH = max(1, $finalH);

        // ID для связи картинки и подписи
        $caption = $data['caption'] ?? null;
        $sourceLink = $data['link'] ?? null;
        $sourceText = $data['alt'] ?? null; // Text for the source link

        // Variables are ready: $caption, $sourceLink, $sourceText

        $figCaptionId = 'figcap-' . ($mediaId ?: Str::random(8));
        // --- Конец расчета размеров --- 
    @endphp
    
    @if(!empty($imageUrl))
    <figure class="editor-js-image{{ $data['classes'] ?? ' '}}">
        <amp-img 
                 width="{{ round($finalW) }}"
                 height="{{ round($finalH) }}"
                 src="{{ img($imageUrl, $desktopWidth, $maxDesktopHeight) }}"
                 @if(!empty($data['caption'])) alt="{{ $data['caption'] }}" @else alt="" @endif
                 layout="responsive"
                 lightbox="amp-lightbox-gallery1" style="cursor: pointer;"
                 aria-describedby="{{ $figCaptionId }}"
                 on="tap:amp-lightbox-gallery1.activate">
        </amp-img>

        {{-- Revert figcaption to structured text (Step 399 state) --}}
        <figcaption id="{{ $figCaptionId }}" class="prose prose-sm my-2 mx-auto text-center">
            @if ($caption)
                <span class="block mb-1">{{ $caption }}</span>
            @endif
            @if ($sourceLink)
                <span class="block text-xs text-gray-500">
                    {{ __('Источник') }}: {{ $sourceText ? __('Изображение').' '.$sourceText : __('Источник изображения') }}
                    <br>
                    {{ $sourceLink }} {{-- Display URL as text --}}
                </span>
            @endif
            {{-- Ensure figcaption isn't completely empty if both are missing --}}
            @if (!$caption && !$sourceLink)
                &nbsp;
            @endif
        </figcaption>
    </figure>

    @endif {{-- This is the closing endif for @if(!empty($imageUrl)) --}}
</div>
