@extends('buildamic::layouts.set')

@php
    $icon_list = $fields->get('icon_list_items')->value()->value() ?? null;
    $style = $fields->get('style')->value() ?? 'default';
    $columns = $fields->get('columns')->value() ?? 'flex flex-wrap gap-0';
@endphp

@section('set_content')


@isset($icon_list)
    <ul class="icon-list icon-list__{{ $style }} {{ $columns  }} m-0">
            @foreach($icon_list as $item)
            @php
                $link_to_entry = $item['link_to_entry']?->value() ?? null;
                $title = $link_to_entry ? $link_to_entry->augmentedValue('title') : $item['title'] ?? '';
                $excerpt = $link_to_entry ? $link_to_entry->augmentedValue('excerpt') : (isset($item['excerpt']) ? $item['excerpt'] : null);
                $url = $link_to_entry ? $link_to_entry->augmentedValue('permalink') : (isset($item['url']) ? $item['url'] : '#');
            @endphp
                {{-- @dd($icon_list) --}}
                <li class="icon-list__item flex flex-col gap-2 items-center md:items-start">
                    <h3 class="text-base m-0">
                        <a class="flex flex-col text-textmain no-underline md:w-full text-center md:text-left font-bold max-w-[19ch]" href="{{ $url }}">
                            {!! $title !!}
                        </a>
                    </h3>
                    @if(isset($excerpt) && $style !== 'inline')
                        {!! modify($excerpt)->stripTags()->safeTruncate([120, '...']) !!}
                    @endif
                    @if(isset($link_to_entry) && $url)
                        <a href="{{ $url }}">Learn More</a>
                    @endif
                </li>
            @endforeach
    </ul>
@endisset

@overwrite
