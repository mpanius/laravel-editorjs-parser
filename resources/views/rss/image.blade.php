{{-- RSS Image --}}
@php
    // Correctly fetch the image URL
    $imageUrl = $data['file']['url'] ?? null;
    $caption = $data['caption'] ?? null;
    $sourceLink = $data['link'] ?? null;
    $sourceText = $data['alt'] ?? null; // Text for the source link

    $rssImageUrl = null;
    if ($imageUrl) {
        // Generate URL with size constraints using the helper as seen in default template
        // Assuming img(url, width, height) handles fitting within dimensions.
        // We cannot reliably force JPEG format here if the helper doesn't explicitly support it.
        $rssImageUrl = img($imageUrl, 1280, 1024);
    }
    $altText = $caption ?: ($sourceText ?: 'Image');
@endphp

@if ($rssImageUrl)
    <img src="{{ $rssImageUrl }}" alt="{{ e($altText) }}" style="max-width: 100%; height: auto;"><br> {{-- Added basic styling --}}
@endif

@if ($caption)
    {!! $caption !!}<br>
@endif
@if ($sourceLink)
    {{ __('Источник') }}: {{ $sourceText ? __('Изображение').' '.$sourceText : __('Источник изображения') }}<br>
    {{ $sourceLink }}<br>
@endif
<br> {{-- Final spacing --}}
