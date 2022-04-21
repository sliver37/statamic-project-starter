@php
    $filters = getTaxFilters($filters);
    $columns = $columns ?? 3;
    $card = $card ?? 'ProductCard';
@endphp

@if(!$filters->isEmpty())
    <v-filter @if($baseFilters) :base-filters='{{ $baseFilters }}' @endif columns="{{ $columns }}" :filters="{{ $filters->toJson() }}" columns="@isset($md_columns) {{ $md_columns }} @endisset lg:grid-cols-{{ $columns }}" card="{{ $card }}" collection="{{ $collection }}"></v-filter>
@endif
