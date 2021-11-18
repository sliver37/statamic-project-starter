@extends('buildamic::layouts.set')

@section('set_content')

    @php
        $before = optional($fields->get('before'))->value();
        $after = optional($fields->get('after'))->value();
        $color = optional($fields->get('field_colour'))->value()->value()->value();
        $action = optional($fields->get('action'))->value() ?? '/';
        $name = optional($fields->get('name'))->value() ?? 'q';
    @endphp

    <div class="search-form-wrapper flex flex-col lg:flex-row flex-wrap items-center gap-4 lg:gap-8" style="--form-field-background-color: white;">
        <div class="search-form__before">
            {!! $before !!}
        </div>
        <div class="flex-grow">
            <x-search-form :name="$name" :action="$action" :color="$color" />
        </div>
        <div class="search-form__after">
            {!! $after !!}
        </div>
    </div>
@overwrite
