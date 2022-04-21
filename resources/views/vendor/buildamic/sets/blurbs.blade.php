@extends('buildamic::layouts.set')

@section('set_content')
    @php
        // Title stuff
        $title = $fields['title']->value()->value() ?? null;
        $blurb_wrapper_class = (string) isset($fields['blurb_wrapper_class']) ? $fields['blurb_wrapper_class']->value()->value() : '';

        // <select> of header sizes
        $title_level = $fields['title_level']->value() ?? null;

        // <color> can be anythingfrom the color picker
        $title_color = $fields['title_color']->value() ?? null;
        $title_size = $fields['title_size']->value() ?? null;
        $title_weight = $fields['title_weight']->value() ?? null;


        // <Bard> content
        $content = $fields['content']->value() ?? null;
        $content_wrapper_class = (string) isset($fields['content_wrapper_class']) ? $fields['content_wrapper_class']->value()->value() : '';

        // <Replicator> of buttons
        $buttons = isset($fields['buttons']) ? $fields['buttons']->value() : null;
        $button_wrapper_classes = (string) isset($fields['button_wrapper_classes']) ? $fields['button_wrapper_classes']->value()->value() : '';

        // <assets> Blurb image (this can be an array of images which we'll handle as a lightweight carousel later)
        $image = $fields['image']->value()->value()->first() ?? null;

        // <select> Of image alignment options
        $image_align = (string) isset($fields['image_align']) ? $fields['image_align']->value()->value()->value() : '';
        $image_wrapper_class = (string) isset($fields['image_wrapper_class']) ? $fields['image_wrapper_class']->value()->value() : '';
        $image_class = (string) isset($fields['image_class']) ? $fields['image_class']->value()->value() : '';

        // <select> Of Object Fit options
        $object_fit = (string) isset($fields['object_fit']) ? $fields['object_fit']->value()->value()->value() : '';

        // <text> fields for width and height (assumed pixels)
        $image_width = (int) isset($fields['image_width']) ? $fields['image_width']->value()->value() : null;
        $image_height = (int) isset($fields['image_height']) ? $fields['image_height']->value()->value() : null;
    @endphp

    <div class="buildamic-blurb {{ $blurb_wrapper_class }}">
        @if(!empty($image))
            <div class="blurb-image-wrapper {{ $image_wrapper_class }}">
                <img loading="lazy" class="blurb-image flex {{ $object_fit }} {{ $image_align }} {{ $image_class }}" src="{{ glide_url($image->url(), ["width"=>($image_width * 2), "height"=>($image_height * 2)]) }}" style="@isset($image_height) height: {{ $image_height }}px; @endisset" alt="{{ $title }}">
            </div>
        @endisset
        <div class="blurb-content {{ $content_wrapper_class }}">
            @isset($title)
                @component('buildamic::components.title', ['data'=> ['title' => $title, 'weight'=>$title_weight, 'size' => $title_size, 'level' => $title_level, 'color' => $title_color, 'class' => 'blurb-title']])@endcomponent
            @endisset
            @isset($content)
                {!! $content !!}
            @endisset
            @isset($buttons)
                @component('buildamic::components.button-group', ['buttons'=> $buttons, 'button_wrapper_classes' => $button_wrapper_classes])@endcomponent
            @endif
        </div>
    </div>
@overwrite
