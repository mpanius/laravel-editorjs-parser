@php
    $dimensions = $data['dimensions'] ?? null;
    if (!$dimensions) {
        return '';
    }
@endphp

<div class="editor-js-block my-6">
    @if(!empty($dimensions['imageUrl']))
        <figure>
            <img width="{{ $dimensions['finalWidth'] }}" 
                 height="{{ $dimensions['finalHeight'] }}"
                 src="{{ $dimensions['imageUrl'] }}"
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
