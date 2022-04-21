@extends('buildamic::layouts.field', ["class" => "pull-quote"])

@section('field_content')
    @php
        $quote = $field->value()->value() ?? null;
    @endphp

    @isset($quote)
        <blockquote>
            {!! $quote !!}
        </blockquote>
    @endisset

@overwrite
