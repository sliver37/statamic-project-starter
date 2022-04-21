@extends('buildamic::layouts.set')

@section('set_content')
    @php
        $options = $set->value()->value();
        $collection = $options['collection'] ?? [];
        $card = $options['card'] ?? $collection . '-card';
        // convert plural to singular
        $terms = (isset($page) && array_key_exists($options['taxonomy'], $page)) ? $page[$options['taxonomy']]->value()->map->slug()->toArray() : [];
        $slug = isset($page) ? $page['slug']->value() : null;
        $rules = isset($options['rules']) ? json_decode($options['rules'], true) : [];
        $included = isset($options['included_entries']) ? ["id:in" => $options['included_entries']] : [];
    @endphp

    @component('components.related-collection', [
        "slug" => $slug,
        "collection" => $collection,
        "limit" => $options['max_items'],
        "columns" => $options['columns'] ?? '',
        "component" => $card,
        "rules" => $rules,
        "relTaxonomy" => $options['taxonomy'],
        "included" => $included,
        "relTerms" => join("|", $terms)])
    @endcomponent
@overwrite
