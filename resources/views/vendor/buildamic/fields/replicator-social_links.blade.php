@extends('buildamic::layouts.field')

@section('field_content')

<ul class="social-links flex gap-4 m-0">
    @foreach($field->value() as $social_link)
        <li><a href="{{ $social_link['url'] }}"><v-icon class="w-8 h-8" name="{{ $social_link['platform'] }}"></v-icon></a></li>
    @endforeach
</ul>

@overwrite
