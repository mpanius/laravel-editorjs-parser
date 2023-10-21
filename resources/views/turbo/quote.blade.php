<div>
    <figure>
        <blockquote>
            <p>
                {!! htmlspecialchars_decode($data['text'] ?? '') !!}
            </p>
            @if(!empty($data['caption']))
                <figcaption>
                    {{$data['caption']}}
                </figcaption>
            @endif

        </blockquote>
    </figure>
</div>