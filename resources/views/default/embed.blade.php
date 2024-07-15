<div class="editor-js-embed relative">



    @switch($data['service'])
        @case('youtube')
            <a class="glightbox w-full href="{!! $data['embed'] !!}" data-type="video" data-source="youtube">
                <img class="w-full aspect-video"
                     src="https://img.youtube.com/vi/{{str_replace('https://www.youtube.com/embed/','',Str::before($data['embed'],'?'))}}/hqdefault.jpg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 absolute "
                     style="top: calc(50% - 64px); left: calc(50% - 64px);" fill="none" viewBox="0 0 24 24"
                     stroke="white" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </a>
            @break
        @case('vkontakte')
            <iframe class="w-full aspect-video" src="{!! str_replace('&amp;','&',$data['embed']) !!}" width="853" height="480"
                    allow="autoplay; encrypted-media; fullscreen; picture-in-picture; screen-wake-lock;" frameborder="0"
                    allowfullscreen></iframe>
            @break
        @case('rutube')
            <iframe class="w-full aspect-video" src="{!! str_replace('&amp;','&',$data['embed']) !!}" width="720" height="405"
                    frameBorder="0" allow="clipboard-write; autoplay" allowFullScreen></iframe>

            @break
        @default
            <iframe class="aspect-w-16 aspect-h-9 w-full h-64"  frameborder="0" allowfullscreen="" src="{!! $data['embed'] !!}"></iframe>
    @endswitch
    <div class="prose prose-2xl my-2 mx-auto text-center">
        {{ $data['caption'] ?? '' }}
    </div>
</div>

