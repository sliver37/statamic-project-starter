<li class="navigation__item navigation__item--depth-{{ $item['depth'] }} navigation__item--{{ preg_replace('/\s+/', '-',strtolower($item['title'])) }}">
    <a href="{{ $item["url"] }}"  class="navigation__link @if($item['is_current'] || $item['is_parent'])bg-red-200 @endif">
    {{ $item["title"] }}
    </a>
    @if(count($item['children']))
    <ul class="navigation__children submenu">
        @foreach($item['children'] as $child)
            @include('components.nav-item', ["item" => $child])
        @endforeach
    </ul>
    @endif
</li>
