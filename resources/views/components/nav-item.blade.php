@php
    $has_children = count($item['children']) ?? false;
    $is_current = $item['is_current'] ?? false;
    $is_ancestor = $item['is_parent'] ?? false;
    $depth = $item['depth'] ?? 1;
    $title = $item["title"];
    $slug = Modify($title)->slugify();
    $url = $item['url'] ?? '#';
    $icon = isset($item['nav_icon']) ? $item['nav_icon']->value() : null;
    $isMegaMenu = $item['id'] === '41d7dcdb-e952-4c7e-b791-47b88af1144d';
@endphp

<li class="nav-item
    @if($has_children) nav-item__has-children flex items-start lg:items-center @endif
    @if($isMegaMenu) nav-item__has-megamenu @endif
    @if($is_current) nav-item__current
    @elseif($is_ancestor) nav-item__ancestor @endif
    nav-item--depth-{{ $depth }}
    nav-item--{{ $slug }}"
>
    <a class="flex items-center gap-2" href="{{ $url }}" class="nav__link">
        @if($icon)
            <i class="fas fa-{{ $icon }}"></i>
        @endif
        {{ $title }}
        @if($has_children || $isMegaMenu)
            <div class="overflow-hidden w-fit inline-block">
                <div class="h-2 w-3 bg-primary -rotate-45 transform origin-top-left"></div>
            </div>
        @endif
    </a>
    @if($isMegaMenu)
    @php
        $top_level_product_cats = \Statamic\Facades\Term::query()->where('taxonomy', 'product_category')->whereNull('parent')->get();
    @endphp
    <ul class="nav__children megamenu shadow-lg">
        @foreach ($top_level_product_cats as $top_level_cat)
            @php
                $childTerms = getChildTerms($top_level_cat);
                $top_level_cat = $top_level_cat->toAugmentedArray();
            @endphp
            <li class="nav-item__has-children">
                <span class="font-bold p-2 flex items-center gap-1 text-xl text-white" style="background-color: {{ $top_level_cat['color'] }}"> {{ $top_level_cat['title'] }} <div class="overflow-hidden lg:hidden w-fit inline-block">
                <div class="h-2 w-3 bg-primary -rotate-45 transform origin-top-left"></div>
            </div></span>
                @isset($childTerms)
                    <ul class="m-0">
                        @foreach ($childTerms as $childTerm)
                        @php
                            $childTerm = $childTerm->toAugmentedArray();
                        @endphp
                            <li>
                                <a href="{{ $childTerm['permalink'] }}" class="flex items-center gap-2">
                                    @isset($childTerm['thumbnail'])
                                        {!! the_thumbnail($childTerm['thumbnail'], ["width" => 64, "height" => 64], ['class' => 'hidden lg:block w-8 h-8', 'loading' => 'lazy']) !!}
                                    @endisset
                                    {{ $childTerm['title'] }}
                                </a>
                            </li>
                            {{-- <thumb-card-hover color="{{ $top_level_cat->get('color')  }}" :entry="{{ $childTerm->values()->merge(['permalink' => $childTerm->url()])->toJson() }}"></thumb-card-hover> --}}
                        @endforeach
                    </ul>
                @endisset
            </li>
        @endforeach
    </ul>
    @elseif($has_children)
        <ul class="nav__children submenu">
            @foreach($item['children'] as $child)
                @include('components.nav-item', ["item" => $child])
            @endforeach
        </ul>
    @endif
</li>
