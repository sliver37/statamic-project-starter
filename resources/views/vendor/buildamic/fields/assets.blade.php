@extends('buildamic::layouts.field')

@section('field_content')
    @php
        $assets = $field->value()->value();
    @endphp

    @if($assets->isNotEmpty())
        <img src="{{ glide_url($assets->first()) }}" />
    @endif
@overwrite
