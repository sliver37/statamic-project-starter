@extends('buildamic::layouts.set')

@section('set_content')
    @php
        // Title stuff
        $title = $fields['title']->value()->value() ?? null;

        // <select> of header sizes
        $title_level = $fields['title_level']->value() ?? null;

        // <color> can be anythingfrom the color picker
        $title_color = $fields['title_color']->value() ?? null;

        // <Bard> content
        $content = $fields['content']->value() ?? null;

        // <Replicator> of buttons
        $buttons = $fields['buttons']->value() ?? null;

        // <assets> Blurb image (this can be an array of images which we'll handle as a lightweight carousel later)
        $image = $fields['image']->value()->value()->first() ?? null;

        // <select> Of image alignment options
        // $image_align = (string) $fields['image_align']->value()->value()->value() ?? 'justify-start';

        // <select> Of Object Fit options
        // $object_fit = (string) $fields['object_fit']->value()->value()->value() ?? '';

        // <text> fields for width and height (assumed pixels)
        // $image_width = (int) $fields['image_width']->value()->value() ?? null;
        // $image_height = (int) $fields['image_height']->value()->value() ?? null;
    @endphp

    <div class="buildamic-blurb">
        @if(!empty($image))
            <div class="blurb-image mb-6 flex {{ $image_align }}" style="@isset($image_height) height: {{ $image_height }}px; @endisset">
                <img class="flex {{ $object_fit }}" src="{{ glide_url($image->url(), ["width"=>($image_width * 2), "height"=>($image_height * 2)]) }}" alt="{{ $title }}">
            </div>
        @endisset
        @isset($title)
            @component('buildamic::components.title', ['data'=> ['title' => $title, 'level' => $title_level, 'color' => $title_color]])@endcomponent
        @endisset
        @isset($content)
            {!! $content !!}
        @endisset
        @isset($buttons)
            @foreach($buttons as $button)
                @component('buildamic::components.button', ['data'=> $button])@endcomponent
            @endforeach
        @endif
    </div>
@overwrite
