<div class="{{ $class ?? '' }}">
    <nav class="product-breadcrumbs max-w-full overflow-auto flex items-center gap-4">
        @breadcrumbs(['include_home' => true, 'separator' =>'*' ])
            @if(!$item['is_current'])
                <a class="white-space-nowrap" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                <i class="fas fa-chevron-right"></i>
            @else
                <span class="font-semibold text-gray-700">{{ $item['title'] }}</span>
            @endif
        @endbreadcrumbs
    </nav>
</div>
