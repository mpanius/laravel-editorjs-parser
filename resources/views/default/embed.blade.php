<div class="editor-js-embed relative">


    @switch($data['service'])
        @case('youtube')
            <script async src="https://cdn.viqeo.tv/js/vq_starter.js"></script>
            <div
                    style="width:100%;height:0;position:relative;padding-bottom: 56.25%;"
                    class="viqeo-external_player"
                    data-playerId="4933"
                    data-profile="17242"
                    data-videoSrc="{{str_replace('&amp;','&',$data['embed'])}}"
            >
                <iframe
                        src="https://cdn.viqeo.tv/embed/?videoSrc={{str_replace('&amp;','&',$data['embed'])}}playerId=4933"
                        width="100%" height="100%" style="position:absolute;" frameBorder="0" allowFullScreen></iframe>
            </div>
            @break
        @case('vkontakte')
            <iframe class="w-full aspect-video" src="{!! str_replace('&amp;','&',$data['embed']) !!}" width="853"
                    height="480"
                    allow="autoplay; encrypted-media; fullscreen; picture-in-picture; screen-wake-lock;" frameborder="0"
                    allowfullscreen></iframe>
            @break
        @case('rutube')
            <iframe class="w-full aspect-video" src="{!! str_replace('&amp;','&',$data['embed']) !!}" width="720"
                    height="405"
                    frameBorder="0" allow="clipboard-write; autoplay" allowFullScreen></iframe>

            @break
        @case('telegram')

            <script async src="https://telegram.org/js/telegram-widget.js?22"
                    data-telegram-post="{{str_replace('https://t.me/','',\Illuminate\Support\Str::beforeLast($data['embed'],'?'))}}"
                    data-width="100%"></script>
            @break
        @default
            <iframe class="aspect-w-16 aspect-h-9 w-full h-64" frameborder="0" allowfullscreen=""
                    src="{!! $data['embed'] !!}"></iframe>
    @endswitch
    <div class="prose prose-2xl my-2 mx-auto text-center">
        {{ $data['caption'] ?? '' }}
    </div>

    @isset($caption)
        <div class="editorjs-embed__caption">{{ $caption }}</div>
    @endisset
</div>

