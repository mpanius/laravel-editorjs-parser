<div class="editor-js-embed relative" 
     data-service="{{ $data['service'] }}"
     data-embed-url="{{ str_replace('&amp;','&',$data['embed']) }}"
     @if($data['service'] === 'telegram')
     data-telegram-post="{{str_replace('https://t.me/','',\Illuminate\Support\Str::beforeLast($data['embed'],'?'))}}"
     @endif>

    <!-- Обычный контент (работает по умолчанию, скрывается в ленте) -->
    <div class="embed-content-default">
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
                            src="https://cdn.viqeo.tv/embed/?videoSrc={{str_replace('&amp;','&',$data['embed'])}}&playerId=4933"
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
    </div>

    <!-- Ленивый контент (показывается только в бесконечной ленте) -->
    <div class="embed-content-lazy" style="display: none;">
        <!-- Плейсхолдер -->
        <div class="embed-placeholder bg-gray-100 dark:bg-gray-800 flex items-center justify-center rounded-lg" 
             style="width:100%; padding-bottom: 56.25%; position: relative;">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 002 2z"></path>
                </svg>
                <span class="text-sm">Загрузка {{ ucfirst($data['service']) }} видео...</span>
            </div>
        </div>
            
        <!-- Динамический контент -->
        <div class="embed-content" style="display: none; position: relative; width: 100%; padding-bottom: 56.25%;">
            @if($data['service'] === 'youtube')
                <div class="viqeo-external_player" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
            @endif
            <!-- Контент создается JS для других сервисов -->
        </div>
    </div>

    <div class="prose prose-2xl my-2 mx-auto text-center text-base">
        {{ $data['caption'] ?? '' }}
    </div>

    @isset($caption)
        <div class="editorjs-embed__caption">{{ $caption }}</div>
    @endisset
</div>

<style>
/* Стили для контроля видимости в зависимости от контекста */
.editor-js-embed .embed-content-default { display: block; }
.editor-js-embed .embed-content-lazy { display: none; }

/* В бесконечной ленте переключаемся на ленивую загрузку */
.infinite-scroll-container .editor-js-embed .embed-content-default { display: none; }
.infinite-scroll-container .editor-js-embed .embed-content-lazy { display: block; }
</style>