<div class="editor-js-block my-6">
    @php

        $mediaId = $data['file']['media_id'] ?? $data['media_id'] ?? null;
    $media = media($mediaId);

    if(empty($media)) {
        $imageUrl = $data['file']['url'] ? normalize($data['file']['url']) : null;
    } else {
     $originalHeight = $media->height;
        $originalWidth = $media->width;
        $imageUrl = $media->getFullUrl();
}
    @endphp

    @if(!empty($imageUrl))
        <figure class="editor-js-image{{ $data['classes'] ?? ' '}}">
            <amp-img layout="responsive"
                     @if($originalWidth > 0)width="{{$originalWidth}}" @endif
                     @if($originalHeight > 0)height="{{$originalHeight}}" @endif
                     src="{{ $imageUrl }}" @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif>
            </amp-img>

            @if (($data['caption'] ?? null) || ($data['source'] ?? null))
                <figcaption class="prose prose-2xl my-2 mx-auto text-center text-base">
                    <span>{{ $data['caption'] ?? ''}}</span><span>{{ $data['source'] ?? '' }}</span>
                </figcaption>
            @endif
        </figure>
    @endif
</div>
