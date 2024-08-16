<figure class="editor-js-image{{ $data['classes'] ?? ' '}}">

    <a href="{{str_replace(['s3.cs.ixbt.com','storage.ixbt.site','s3f.ixbt.site'],'storage.ixbt.com',$data['file']['url'])}}" class="glightbox"
       @if($data['caption'] ?? null) data-title="{{$data['caption']}}" @endif>
        <img @if(!empty($data['file']['width']) && $data['file']['width'] != 0)width="{{$data['file']['width']}}"
             height="{{$data['file']['height']}}" @endif
             decoding="async" src="{{ thumbor($data['file']['url'],736) }}"
             @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif>
    </a>
    @if (($data['caption'] ?? null) || ($data['alt'] ?? null) || ($data['link'] ?? null) )
        <figcaption class="prose prose-2xl my-2 mx-auto text-center"><span>{{ $data['caption'] ?? ''}}</span>
            @if($data['link'] ?? null)
                <div class="text-xs @if(!empty($data['caption'] ?? null))mt-2 @endif"><a target="_blank"
                                                                                         class="no-underline text-gray-500 hover:text-blue-500"
                                                                                         href="{{$data['link']}}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="w-3 h-3 inline">
                            <path fill-rule="evenodd"
                                  d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z"
                                  clip-rule="evenodd"/>
                            <path fill-rule="evenodd"
                                  d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z"
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ $data['alt'] ? __('Изображение').' '.$data['alt']: __('Источник изображения') }}</a></div>
            @endif</figcaption>
    @endif
</figure>
