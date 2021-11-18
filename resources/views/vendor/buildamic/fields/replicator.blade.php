@extends('buildamic::layouts.field')

@section('field_content')
    @php
        $items = $field->value()->value() ?? [];
    @endphp

    @isset($items)
        <div class="accordions" data-istoggle>
            @foreach ($items as $item)
                @php
                    $title = $item['title']->value();
                    $content = $item['content']->value();
                @endphp
                <div class="accordion">
                    <div class="accordion__header items-center">
                        {{ $title }}
                        <animated-toggle-plus></animated-toggle-plus>
                        {{-- <v-icon class="toggle-icon toggle-icon--chevron text-secondary" name="chevron-right"></v-icon> --}}
                    </div>
                    <div class="accordion__content">
                        {!! $content !!}
                    </div>
                </div>
            @endforeach
        </div>
    @endisset
@overwrite
