@extends('buildamic::layouts.field')

@section('field_content')

<ul class="social-links flex gap-4 m-0">
    @foreach($field->value() as $social_link)
        <li><a style="color: {{ $social_link['color'] ?? '' }};" href="{{ $social_link['url'] }}"><i class="w-8 h-8 fab fa-{{ modify($social_link['platform'])->lowercase() }}"></i></a></li>
    @endforeach
</ul>

@overwrite
