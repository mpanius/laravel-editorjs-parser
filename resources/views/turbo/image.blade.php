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
<figure><img src="{{ $imageUrl }}"
             @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif>@if (!empty($data['caption']))
        <figcaption>{{ $data['caption'] }}</figcaption>
    @endif</figure>