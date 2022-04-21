@php
    $show_title = $data['show_title'] ?? null;
@endphp

@if(is_null($show_title) ? true : $show_title)
    <{{ $data['level'] ?? 'h3' }} class="{{ $data['color'] ?? 'textmain' }} {{ $data['size'] ?? '' }} {{ $data['weight'] ?? '' }} {{ $data['class'] ?? '' }}">{{ $data['title'] ?? null }}</{{ $data['level'] ?? 'h3' }}>
@endif
