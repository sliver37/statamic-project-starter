<ul>
    @foreach($navItems as $navItem)
        <li>
            {{ $navItem['title'] }} {{ $navItem['url'] }}
            @if(!empty($navItem['children']))
                {!! $navHelper->render($navItem['children']) !!}
            @endif
        </li>
    @endforeach
</ul>