<div class="editor-js-block my-6">
    @php
        $mediaId = $data['file']['media_id'] ?? $data['media_id'] ?? null;
        $originalHeight = null;
        $originalWidth = null;
     if ($mediaId && ($media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId))) {
           $imageUrl = $media->getUrl() ?? null;
           $originalWidth = $media->width ?? $media->getCustomProperty('width') ?? 0;
           $originalHeight = $media->height ?? $media->getCustomProperty('height') ?? 0;

       } else {
           $imageUrl = $data['file']['url'] ? normalize($data['file']['url']) : null;
           $originalWidth = $data['file']['width'] ?? 0;
           $originalHeight = $data['file']['height'] ?? 0;
     }
     $width = 1000;
     $height = null;
     if($originalWidth > 2000) {
         $width = 2000;
         $height = round($originalHeight * 2000 / $originalWidth);
     }elseif (($originalWidth > 0) && ($originalWidth < 1000) && ($originalHeight > 0)){

         $height = round($originalHeight * 1000 / $originalWidth);
     }

    @endphp

    @if(!empty($imageUrl))
        <figure>
            <img width="{{$width}}" @if($height) height="{{$height}}" @endif
            src="{{$height}}" src="{{ img($imageUrl, $width, $height) }}"
                 @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif
            />


            @if (($data['caption'] ?? null) || ($data['source'] ?? null))
                <figcaption>
                    <span>{{ $data['caption'] ?? ''}}</span><span>{{ $data['source'] ?? '' }}</span>
                </figcaption>
            @endif
        </figure>
    @endif
</div>
