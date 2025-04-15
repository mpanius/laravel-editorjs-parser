{{-- /Users/mikhailpanyushkin/code/xcom/laravel-editorjs-parser/resources/views/default/image.blade.php --}}
@php
    // --- Извлечение данных и подготовка переменных ---
    $fileData = $data['file'] ?? [];
    $customProps = $fileData['custom_properties'] ?? [];
    $imageUrl = $fileData['url'] ?? null;
    $mediaId = $fileData['media_id'] ?? null;

    // Попытка получить URL из MediaLibrary, если его нет, но есть media_id
    if (!$imageUrl && $mediaId && class_exists(\Spatie\MediaLibrary\MediaCollections\Models\Media::class)) {
        $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId);
        if ($media) {
            $imageUrl = $media->getUrl();
            // Попытаемся получить width/height/blurhash из custom_properties медиа, если их нет в $fileData
            if (empty($fileData['width']) && $media->hasCustomProperty('width')) {
                $fileData['width'] = $media->getCustomProperty('width');
            }
            if (empty($fileData['height']) && $media->hasCustomProperty('height')) {
                $fileData['height'] = $media->getCustomProperty('height');
            }
            if (empty($customProps['blurhash']) && $media->hasCustomProperty('blurhash')) {
                $customProps['blurhash'] = $media->getCustomProperty('blurhash');
            }
        }
    }

    // Основные данные изображения
    $width = $customProps['width'] ?? $fileData['width'] ?? null;
    $height = $customProps['height'] ?? $fileData['height'] ?? null;
    $blurhash = $customProps['blurhash'] ?? null;
    $caption = $data['caption'] ?? null;
    $altText = $data['alt'] ?? $caption ?? ''; // Alt из источника или caption
    $sourceText = $data['alt'] ?? null; // Текст источника
    $sourceLink = $data['link'] ?? null; // Ссылка на источник

    // CSS классы
    $figureClasses = ['editor-js-image-plus', 'relative', 'my-6']; // 'my-6' для вертикального отступа
    // Добавляем любые дополнительные классы из data['classes'], если они есть
    if (!empty($data['classes'])) {
         $figureClasses[] = $data['classes'];
    }

    // Размеры для srcset (предполагаем, что img() генерирует URL нужной ширины)
    $srcsetWidths = [320, 640, 880, 1200, 1760, 2400];
    $srcset = collect($srcsetWidths)
        ->map(fn($w) => img($imageUrl, $w) . ' ' . $w . 'w') // Используем ваш img() хелпер
        ->implode(', ');

    // Атрибут sizes - Уточнено по замерам
    $sizes = '(max-width: 639px) 100vw, (max-width: 719px) calc(100vw - 48px), (max-width: 1023px) 840px, (max-width: 1339px) 620px, 920px';

    // Стиль для плейсхолдера
    $placeholderStyle = '';
    $aspectRatioStyle = '';
    if ($width && $height) {
        $aspectRatio = round(($height / $width) * 100, 4);
        // Используем современный CSS aspect-ratio
         $aspectRatioStyle = "aspect-ratio: {$width} / {$height};";
         $placeholderStyle = generateBlurhashBackgroundStyle($blurhash, 32, round(32 * $height / $width));
    } else {
         // Fallback, если нет размеров - задаем стандартный aspect-ratio 16:9
         $aspectRatioStyle = "aspect-ratio: 16 / 9;";
         $placeholderStyle = generateBlurhashBackgroundStyle($blurhash, 32, 18); // 16:9 для 32px ширины
    }

@endphp

{{-- Фигура рендерится всегда, чтобы показать плейсхолдер или само изображение --}}
<figure class="{{ implode(' ', $figureClasses) }}">
    <div class="relative"> {{-- Контейнер для позиционирования плейсхолдера и изображения --}}

        {{-- 1. Плейсхолдер Blurhash (Всегда рендерим, если есть стиль) --}}
        @if ($placeholderStyle)
        <div
            class="blurhash-placeholder absolute inset-0 z-10" {{-- Убран класс transition-opacity --}}
            style="{{ $placeholderStyle }} {{ $aspectRatioStyle }}"
            aria-hidden="true"
        ></div>
        @endif

        {{-- 2. Изображение с <picture> (Только если есть URL) --}}
        @if (!empty($imageUrl))
        <picture
            class="image-wrapper relative z-20 block @if ($placeholderStyle) opacity-0 transition-opacity duration-500 ease-in @endif" {{-- Эффект появления только если был плейсхолдер --}}
            style="{{ $aspectRatioStyle }}" {{-- Применяем aspect-ratio --}}
        >
            {{-- Источники для разных размеров экрана --}}
            <source srcset="{{ $srcset }}" sizes="{{ $sizes }}">

            {{-- Основное изображение (fallback + для JS) --}}
            <img
                src="{{ img($imageUrl, $srcsetWidths[0]) }}" {{-- Самый маленький размер как src --}}
                alt="{{ $altText }}"
                width="{{ $width ?? '' }}" {{-- Оригинальные размеры для семантики, если есть --}}
                height="{{ $height ?? '' }}"
                loading="lazy"
                decoding="async"
                class="main-image absolute inset-0 w-full h-full object-cover" {{-- Растягиваем внутри контейнера с aspect-ratio --}}
            >
        </picture>
        @endif {{-- Конец if (!empty($imageUrl)) для <picture> --}}
    </div>

    {{-- 3. Метаданные (Caption, Источник) (Всегда рендерим, если есть данные) --}}
    @if ($caption || $sourceText)
        <figcaption class="image-caption block mt-2 px-4 text-sm text-center text-gray-600 dark:text-gray-400">
            @if ($caption)
                <span>{{ $caption }}</span>
            @endif
            @if ($sourceText)
                <span class="block text-xs mt-1">
                    @if ($sourceLink)
                        <a href="{{ $sourceLink }}" target="_blank" rel="noopener nofollow" class="hover:text-primary-500 transition-colors duration-200">
                            {{ __('Источник') }}: {{ $sourceText }}
                        </a>
                    @else
                        {{ __('Источник') }}: {{ $sourceText }}
                    @endif
                </span>
            @endif
        </figcaption>
    @endif
</figure>
