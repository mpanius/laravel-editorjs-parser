<div class="editor-js-embed">

    @switch($data['service'])
        @case('youtube')
        <amp-youtube data-videoid="{{str_replace('https://www.youtube.com/embed/','',Str::before($data['embed'],'?'))}}"
        layout="responsive"
        width="480"
        height="270">
        </amp-youtube>
        @break
        @case('vkontakte')
            <amp-iframe src="{!! str_replace('&amp;','&',$data['embed']) !!}" width="853" height="480" sandbox="allow-scripts allow-same-origin"
                    allow="autoplay; encrypted-media; fullscreen; picture-in-picture; screen-wake-lock;" frameborder="0" layout="responsive"
                        allowfullscreen></amp-iframe>
            @break
        @case('rutube')
            <amp-iframe src="{!! str_replace('&amp;','&',$data['embed']) !!}" width="720" height="405" sandbox="allow-scripts allow-same-origin"
                    frameBorder="0" layout="responsive" allow="clipboard-write; autoplay" allowFullScreen></amp-iframe>

            @break
        @default
            <amp-iframe src="{!! str_replace('&amp;','&',$data['embed']) !!}" width="853" height="480" sandbox="allow-scripts allow-same-origin"
                        allow="autoplay; encrypted-media; fullscreen; picture-in-picture; screen-wake-lock;" frameborder="0" layout="responsive"
                        allowfullscreen></amp-iframe>
    @endswitch

    <div class="prose prose-2xl my-2 mx-auto text-center">
        {{ $data['caption'] ?? '' }}
    </div>
</div>

