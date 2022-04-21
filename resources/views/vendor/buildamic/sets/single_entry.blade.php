@extends('buildamic::layouts.set')

@section('set_content')
    @php
        $entry = $fields->get('entry')->value()->value()->toAugmentedArray();
        $title = $fields->get('title')->value()->value() ?? "";
        $title_level = $fields->get('title_level')->value()->value();
        $title_color = $fields->get('title_color')->value()->value();
        $thumbnail = $entry['thumbnail'] ?? null;
        $hideThumb = $fields->get('hide_featured_image')->value()->value() ?? null;
        $entryTitleLevel = $fields->get('entry_title_level')->value()->value() ?? 'h3';
    @endphp
    <div class="entry">
        @isset($title)
            @component('buildamic::components.title', ['data'=> ['title' => $title, 'level' => $title_level, 'color' => $title_color]])@endcomponent
        @endisset
        <div class="flex flex-col gap-4">
            @if($thumbnail && !$hideThumb)
                <div class="entry-thumbnail">
                    @glide($thumbnail, ['width'=> 980, 'height'=> 580])
                        <img src="{{ $url }}" alt="{{ $entry['title'] }}" />
                    @endglide
                </div>
             @endif
            <{{ $entryTitleLevel }} class="m-0">{{ $entry['title'] }}</{{ $entryTitleLevel }}>
            <div class="entry-content">
                {!! modify($entry['content'])->stripTags()->safeTruncate([200, '...']) !!}
            </div>
            <a href="{{ $entry['permalink'] }}" class="btn">Learn More</a>
        </div>
    </div>
@overwrite
