@php
    $text = $data['text'];
    $icon = method_exists( $data['icon'], 'value' ) ? $data['icon']->value() : $data['icon'];
    $icon_disabled = optional($data['disable_icon'] ?? null)->value();
    $button_style = optional($data['style'] ?? null)?->value()?->value() ?? null;
@endphp

@isset($text)
    <a class="btn text-center {{ $data['class'] ?? "" }} {{ $button_style ? "btn--{$button_style}" : null }}" href="{{ $data['url'] ?? '#' }}">
        <span class="flex items-center justify-center">
            {{ $text }}
            @if(isset($icon) && !$icon_disabled)
                @glide($icon)
                    <img src="{{ $url }}">
                @endglide
            @endisset
        </span>
    </a>
@endisset
