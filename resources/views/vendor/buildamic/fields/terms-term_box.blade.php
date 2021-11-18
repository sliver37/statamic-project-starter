@extends('buildamic::layouts.field')

@section('field_content')
    @php
        $terms = $field->value()->value();
    @endphp

    @if($terms->isNotEmpty())
        <ul class="terms terms__box m-0 flex flex-col gap-5 lg:flex-row lg:gap-10 text-center">
            @foreach($terms as $term)
                <li class="term group flex-grow flex-1 bg-white hover:bg-secondary transition-colors shadow-lg text-3xl p-4 rounded term-{{ $term->slug() }}">
                  <a href="{{ activity_filter_link($term->taxonomy()) . $term->slug() }}" class="term-inner flex text-textmain hover:text-textmain flex-col items-center border-2 p-4 lg:p-8 rounded border-dashed border-tertiary">
                        <v-icon class="term-icon overflow-visible" name="{{ get_asset_name_from_path($term->get('icon')) }}"></v-icon>
                        <span class="lowercase flex items-center">{{ $term->title() }} <v-icon class="text-secondary group-hover:text-white w-4 h-4 ml-2" name="chevron-right"></v-icon></span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@overwrite
