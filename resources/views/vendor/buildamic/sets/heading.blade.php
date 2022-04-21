@extends('buildamic::layouts.set')

@section('set_content')
    @php
        // Title stuff
        $title = $fields['title']->value()->value() ?? null;

        // <select> of header sizes
        $title_level = $fields['title_level']->value() ?? null;

        // <color> can be anythingfrom the color picker
        $title_color = $fields['title_color']->value() ?? null;

        // <Replicator> of buttons
        $buttons = $fields['buttons']->value() ?? null;
    @endphp


    @isset($title)
        @component('buildamic::components.title', ['data'=> ['title' => $title, 'level' => $title_level, 'color' => $title_color]])@endcomponent
    @endisset
    <div class="heading-buttons">
        @isset($buttons)
            @foreach($buttons as $button)
                @component('buildamic::components.button', ['data'=> $button])@endcomponent
            @endforeach
        @endif
    </div>

@overwrite
