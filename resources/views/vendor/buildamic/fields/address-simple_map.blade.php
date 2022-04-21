@extends('buildamic::layouts.field')

@php
    $latlng = $field->value()->value()['center'] ?? null;
@endphp

@section('field_content')
    @isset($latlng)
        <v-map-location :location="{ lat: {{ $latlng[1] }}, lng: {{ $latlng[0] }} }"></v-map-location>
    @endisset
@overwrite
