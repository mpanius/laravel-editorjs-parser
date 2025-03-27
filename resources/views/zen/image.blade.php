<div class="editor-js-block my-6">
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
    @endphp
    
    @if(!empty($imageUrl))
    <figure>
        <img
                 @if(!empty($data['file']['width']) && $data['file']['width'] != 0)width="{{$data['file']['width']}}"
                 height="{{$data['file']['height']}}" @endif
                 src="{{ normalize($imageUrl) }}" @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif
        />


        @if (($data['caption'] ?? null) || ($data['source'] ?? null))
            <figcaption>
                <span>{{ $data['caption'] ?? ''}}</span><span>{{ $data['source'] ?? '' }}</span>
            </figcaption>
        @endif
    </figure>
    @endif
</div>
