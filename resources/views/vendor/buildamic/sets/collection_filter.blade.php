@extends('buildamic::layouts.set')

@section('set_content')
    @php
        $values = collect($set->value()->value())
            ->only(['terms']);
        $filters = $fields->get('filter_fields')->value()->value() ?? null;
        $card = $set->value()->value()['card'] ?? '';
        $collection = $set->value()->value()['collection'] ?? '';
        $columns = $set->value()->value()['columns'] ?? 'grid-cols-2';

    @endphp
    <div class="collection-filter md:flex flex-wrap w-full">
        @if(isset($filters))
             <x-taxonomy-filters :columns="$columns" :collection="$collection" :card="$card" :filters="$filters" />
        @endif
    </div>
@overwrite
