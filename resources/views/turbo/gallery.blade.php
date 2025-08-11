@php($items = $data['items'] ?? [])
@if(!empty($items))
    <div class="editor-js-gallery my-6">
        @foreach($items as $item)
            @php
                $mediaId = $item['media_id'] ?? null;
                $media = $mediaId ? media($mediaId) : null;
                $src = $media ? $media->getFullUrl() : ($item['url'] ?? '');
            @endphp
            @if($src)
                <figure class="editor-js-image">
                    <img src="{{ $src }}" alt="{{ $item['caption'] ?? '' }}"/>
                    @if (!empty($item['caption']))
                        <figcaption class="prose my-2 mx-auto text-center text-base">{{ $item['caption'] }}</figcaption>
                    @endif
                </figure>
            @endif
        @endforeach
    </div>
@endif


