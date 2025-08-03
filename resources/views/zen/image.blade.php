<div class="editor-js-block my-6">
    @php
        $mediaId = $data['file']['media_id'] ?? $data['media_id'] ?? null;
        $originalHeight = null;
        $originalWidth = null;
     if ($mediaId && ($media = \Illuminate\Support\Facades\Cache::remember('media_'.$mediaId, 1800, fn() =>  \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId)))) {
           $imageUrl = $media->getUrl() ?? null;
           $originalWidth = $media->width ?? 0;
           $originalHeight = $media->height ?? 0;

       } else {
           $imageUrl = $data['file']['url'] ? normalize($data['file']['url']) : null;
           $originalWidth = $data['file']['width'] ?? 0;
           $originalHeight = $data['file']['height'] ?? 0;
     }
     if($originalWidth > 2000) {
         $width = 2000;
         $height = round($originalHeight * 2000 / $originalWidth);
     }
     if(($originalWidth > 0) && ($originalWidth < 700)){
         $width = 700;
         $height = round($originalHeight * 700 / $originalWidth);
     }
     if($originalWidth == 0){
         $width = 700;
         $height = 700;
     }

    @endphp

    @if(!empty($imageUrl))
    <figure>
        <img width="{{$width}}" height="{{$height}}" src="{{ img($imageUrl, $width, $height, false) }}" @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif
        />


        @if (($data['caption'] ?? null) || ($data['source'] ?? null))
            <figcaption>
                <span>{{ $data['caption'] ?? ''}}</span><span>{{ $data['source'] ?? '' }}</span>
            </figcaption>
        @endif
    </figure>
    @endif
</div>
