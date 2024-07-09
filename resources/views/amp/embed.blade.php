<div class="editor-js-embed">

    @if($data['service'] == 'youtube')
        <amp-youtube data-videoid="{{str_replace('https://www.youtube.com/embed/','',Str::before($data['embed'],'?'))}}"
        layout="responsive"
        width="480"
        height="270">
        </amp-youtube>
    @else
        <amp-iframe   width="480"
                      height="270"
                      sandbox="allow-scripts allow-same-origin"
                      layout="responsive"
                      allow="autoplay; encrypted-media; fullscreen; picture-in-picture; screen-wake-lock;"
                      frameborder="0" class="aspect-w-16 aspect-h-9 w-full h-64" src="{{ $data['embed'] }}"></amp-iframe>
    @endif
    <div class="prose prose-2xl my-2 mx-auto text-center">
        {{ $data['caption'] ?? '' }}
    </div>
</div>

