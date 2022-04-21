@extends('buildamic::layouts.set')

@section('set_content')
    @php
        $options = $set->value()->value();
        $collection = $options['collection'] ?? [];
        $card = $options['card'] ?? $collection . '-card';
        $maxItems = $options['max_items'] ?? 3;
        $terms = (isset($page) && array_key_exists($options['taxonomy'], $page)) ? $page[$options['taxonomy']]->value()->map->slug()->toArray() : [];
        $slug = isset($page) ? $page['slug']->value() : null;
        $defaultRules = ['parent:is'=>$page['id'], ];
        $rules = isset($options['rules']) ? array_merge(json_decode($options['rules'], true), $defaultRules) : $defaultRules;
        $included = isset($options['included_entries']) ? ["id:in" => $options['included_entries']] : [];
    @endphp

    @component('components.related-collection', [
        "slug" => $slug,
        "collection" => $collection,
        "limit" => $options['max_items'],
        "columns" => $options['columns'] ?? 'md:grid-cols-3',
        "component" => $card,
        "rules" => $rules,
        "relTaxonomy" => $options['taxonomy'] ?? null,
        "included" => $included,
        "relTerms" => join("|", $terms)])
    @endcomponent
@overwrite
