@extends('buildamic::layouts.field')

@section('field_content')
    @php
        $items = $field->value()->value() ?? [];
    @endphp

    @isset($items)
        <hmw-tabs :model-value="0">
            <hmw-tabs-header-tabs>
                @foreach ($items as $item)
                    @php
                        $header = isset($item['header']) ? $item['header']->value() : null;
                    @endphp
                    <hmw-tab-header>
                        {{ $header }}
                    </hmw-tab-header>
                 @endforeach
            </hmw-tabs-header-tabs>
            <hmw-tabs-content-panels>
                @foreach ($items as $item)
                    @php
                        $content = isset($item['content']) ? $item['content']->value() : null;                    @endphp
                    <hmw-tab-content>
                        {!! $content !!}
                    </hmw-tab-content>
                @endforeach
            </hmw-tabs-content-panels>
        </hmw-tabs>
    @endisset
@overwrite
