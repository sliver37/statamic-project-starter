@php
    $slug = $slug ?? '';
    $limit = $limit ?? 3;
    $columns = $columns ?? 'lg:grid-cols-3';
    $sort = $sort ?? 'order';
    $relTaxonomy = $relTaxonomy ?? '';
    $relTerms = isset($relTerms) ? $relTerms : '';
    $gap = $gap ?? 'gap-6';
    $classes = $classes ?? '';
    $rules = $rules ?? [];
    $included = $included ?? [];
@endphp

<div class="grid list-collections {{ $gap }} list-collections__{{ $collection }} @if($columns) {{ $columns }} @endif">
        @collection($collection, array_merge(['slug:isnt' => "{$slug}", 'limit'=> "{$limit}", "taxonomy:{$relTaxonomy}" => "{$relTerms}"], $rules, $included))
            @if($entry["no_results"] ?? false)
                @collection($collection, ['slug:isnt'=>"{$slug}", 'limit'=> "{$limit}", 'sort' => $sort])
                    @if($entry["no_results"] ?? false)
                        <p class="text-center">No results</p>
                    @else
                        @data($entry)
                            @if(view()->exists($component))
                                <dynamic-component :component="$component" :entry="$data"></dynamic-component>
                            @else
                                <component classes="{{ $classes }}" is="{{ $component }}" :entry='{{ json_encode($data) }}' /></component>
                            @endif
                        @enddata
                    @endif
                @endcollection
            @else
                @data($entry)
                    @if(is_array($data[array_key_first($data)]))
                        @foreach($data as $item)
                            @if(view()->exists($component))
                                <dynamic-component :component="$component" :entry="$item"></dynamic-component>
                            @else
                                <component classes="{{ $classes }}" is="{{ $component }}" :entry='{{ json_encode($item) }}' /></component>
                            @endif
                        @endforeach
                    @else
                        @if(view()->exists($component))
                            <dynamic-component :component="$component" :entry="$data"></dynamic-component>
                        @else
                            <component classes="{{ $classes }}" is="{{ $component }}" :entry='{{ json_encode($data) }}' /></component>
                        @endif
                    @endif
                @enddata
            @endif
        @endcollection
</div>
