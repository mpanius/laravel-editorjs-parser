<figure><img src="{{ $data['file']['url'] }}"
             @if(!empty($data['caption']))alt="{{ $data['caption'] }}"@endif>@if (!empty($data['caption']))
        <figcaption>{{ $data['caption'] }}</figcaption>
    @endif</figure>