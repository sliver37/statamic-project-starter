@extends('buildamic::layouts.field')

@section('field_content')
    @php
        $slider = $field->value()->value();
        $collection = $slider->get('collection') ?? 'pages';
        $template = $slider->get('template');
        $sliderType = $slider->has('slider_style') ? $slider->get('slider_style') : 'generic-slider';
    @endphp

    @php
        $slides = collect(optional($slider->augmentedValue('slides'))->value() ?? []);
    @endphp
        <{{ $sliderType }} :slides-per-view="1" :show-navigation="true">
            @if($slides->isNotEmpty())
                @foreach($slides as $slide)
                    <div>
                        @if($slide['image'])
                            <div class="slide-image">
                                @glide($slide['image']->value(), ['width' => '1920', 'height' => '1080'])
                                    <img src="{{ $url }}" alt="{{ $slide['title']->value() }}" />
                                @endglide
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </{{ $sliderType }}>
@overwrite
