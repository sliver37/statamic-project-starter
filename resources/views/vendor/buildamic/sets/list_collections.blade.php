@extends('buildamic::layouts.set')

@section('set_content')
    @php
        $options = $set->value()->value();
        $collection = $options['collection'] ?? [];
        $template = $options['template'] ?? $collection . '-card';
        // convert plural to singular
        $terms = (isset($page) && array_key_exists($options['taxonomy'], $page)) ? $page[$options['taxonomy']]->value()->map->slug()->toArray() : [];
        $slug = isset($page) ? $page['slug']->value() : null
    @endphp

    @component('components.related-collection', [
        "slug" => $slug,
        "collection" => $collection,
        "limit" => $options['max_items'],
        "component" => $template,
        "relTaxonomy" => $options['taxonomy'],
        "relTerms" => join("|", $terms)])
    @endcomponent
@overwrite
