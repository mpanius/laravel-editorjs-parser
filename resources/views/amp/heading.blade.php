{{-- AMP Heading (H1-H6) --}}
@php $level = $data['level'] ?? '2'; @endphp
<h{{ $level }}>{!! $data['text'] !!}</h{{ $level }}>
