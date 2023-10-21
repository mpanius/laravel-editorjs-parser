@if ($data['service'] === 'youtube')
    <div data-block="youtube" data-url="https://www.youtube.com/watch?v={{ $data['source'] }}"></div>
@elseif ($data['service'] === 'vimeo')
    <div data-block="vimeo" data-url="https://vimeo.com/{{ $data['source'] }}"></div>
@elseif ($data['service'] === 'rutube')
    <div data-block="rutube" data-url="{{ $data['source'] }}"></div>
@endif