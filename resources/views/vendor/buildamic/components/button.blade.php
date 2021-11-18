@php
    $text = $data['text'];
    $icon = $data['icon']->value() ?? null;
    $icon_disabled = $data['disable_icon']->value();
@endphp

@isset($text)
    <a class="btn btn--{{ $data['style']->value()->value() ?? 'unstyled' }}" href="{{ $data['url'] ?? '#' }}">
        <span class="flex items-center">
            {{ $text }}
            @if(isset($icon) && !$icon_disabled)
                <v-icon class="ml-2" name="{{ $icon->get('filename') }}"></v-icon>
            @endisset
        </span>
    </a>
@endisset
