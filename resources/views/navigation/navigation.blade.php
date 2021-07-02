<ul>
    @foreach($navigation as $navItem)
        <li>
            {{ $navItem['title'] }} {{ $navItem['url'] }}
            @if(!empty($navItem['children']))
                {!! $navigationHelper->render($navItem['children']) !!}
            @endif
        </li>
    @endforeach
</ul>