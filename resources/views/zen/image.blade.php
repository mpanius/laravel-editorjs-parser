<div class="editor-js-block my-6">
    @php
        $mediaId = $data['file']['media_id'] ?? $data['media_id'] ?? null;
        $originalHeight = null;
        $originalWidth = null;
     if ($mediaId && ($media = \Illuminate\Support\Facades\Cache::remember('media_'.$mediaId, 1800, fn() =>  \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId)))) {
           $imageUrl = $media->getUrl() ?? null;
           $originalWidth = $media->getCustomProperty('width') ?? 0;
           $originalHeight = $media->getCustomProperty('height') ?? 0;
       } else {
           $imageUrl = $data['file']['url'] ? normalize($data['file']['url']) : null;
           $originalWidth = $data['file']['width'] ?? 0;
           $originalHeight = $data['file']['height'] ?? 0;
     }
    @endphp

    @if(!empty($imageUrl))
    <figure>
        <img
                @if($originalWidth > 0)width="{{$originalWidth}}" @endif
        @if($originalHeight > 0)height="{{$originalHeight}}" @endif
                 src="{{ $imageUrl }}" @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif
        />


        @if (($data['caption'] ?? null) || ($data['source'] ?? null))
            <figcaption>
                <span>{{ $data['caption'] ?? ''}}</span><span>{{ $data['source'] ?? '' }}</span>
            </figcaption>
        @endif
    </figure>
    @endif
</div>
