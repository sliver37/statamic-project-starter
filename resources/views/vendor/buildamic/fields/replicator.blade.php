@extends('buildamic::layouts.field')

@section('field_content')
    @php
        $items = $field->value()->value() ?? [];
    @endphp

    @isset($items)
        <accordion>
            @foreach ($items as $item)
                @php
                    $title = isset($item['title']) ? $item['title']->value() : null;
                    $content = isset($item['content']) ? $item['content']->value() : null;
                @endphp
                <accordion-panel>
                    <accordion-panel-header>
                        {{ $title }}
                    </accordion-panel-header>
                    <accordion-panel-content>
                        {!! $content !!}
                    </accordion-panel-content>
                </accordion-panel>
            @endforeach
        </accordion>
    @endisset
@overwrite
