@extends('buildamic::layouts.field')

@section('field_content')
    @php
        $video_url = $field->value()->value() ?? "";
    @endphp

    <youtube-player video-id="{{ $video_url }}"></youtube-player>
@overwrite
