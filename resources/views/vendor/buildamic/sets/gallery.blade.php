@extends('buildamic::layouts.set')

@section('set_content')
    @php
        $images = $fields?->get('images')->value() ?? null;
        $image_class = $fields?->get('image_class')?->value()->value() ?? "w-full h-auto object-cover";
        $columns = $fields?->get('columns')->value();
        $gallery_slider = $fields?->get('gallery_slider') ? $fields->get('gallery_slider')?->value()?->value() : false;
    @endphp
    @isset($images)

    {{-- @dd($fields->get('gallery_slider')->value()) --}}
        @if($gallery_slider)
        {{ $gallery_slider }}
            <generic-slider :slides-per-view="1" :show-navigation="true" :show-pagination="true">
        @else
            <div class="grid {{ $columns }}">
        @endif

            @foreach ($images->value() as $image)
            <div class="flex flex-col items-center w-full">
                <img loading="lazy" class="flex m-0 {{ $image_class }}" src="{{ $image->url() }}" alt="{{ $image->meta()['alt'] ?? '' }}">
                @if(isset($image->meta()['data']['caption']))
                    <span>{{ $image->meta()['data']['caption'] }}</span>
                @endif
            </div>
            @endforeach

        @if($gallery_slider)
            </generic-slider>
        @else
            </div>
        @endif
    @endisset
@overwrite
