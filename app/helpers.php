<?php

use Statamic\Assets\Asset;
use Statamic\Facades\Antlers;
use Statamic\Tags\Glide as GlideTag;
use Statamic\Facades\Term;
use Statamic\Fields\Value;


if (! function_exists('glide_url')) {
    function glide_url(string | Asset $asset, array $params = [])
    {
        if ($asset instanceof Asset) {
            $asset = $asset->id();
        }

        unset($params['src']);
        unset($params['id']);
        unset($params['path']);

        $params['src'] = $asset;

        return tag('glide', $params);
    }
}

if (!function_exists('the_thumbnail')) {
    function the_thumbnail($thumbnail, array $params = [], array $attributes = []) {

        // Add a default for when null is passed
        $thumbnail = isset($thumbnail) ? $thumbnail : "assets/EKgokC4UYAA33d9.jpeg";

        // dd($thumbnail);

        // Get or generate the thumbnail
        $data = (new GlideTag)
                ->setParser(Antlers::parser())
                ->setContext([])
                ->setParameters($params)
                ->generate(method_exists($thumbnail, 'value') ? $thumbnail->value() : $thumbnail);

        if (!$data) {
            return;
        }

        $attribute_string = '';

        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $attribute_string .= $key . '="' . $value . '" ';
            }
        }

        $url = isset($data[0]) ? $data[0]['url'] : $data['url'];
        $alt = isset($data[0]) ? ($data[0]['alt'] ?? "") : ($data['alt'] ?? "");

        // dd($data);
        return sprintf('<img %s src="%s" %s>', $attribute_string, $url, $alt ? "alt='$alt'" : '');
    }
}

if (!function_exists('getTaxFilters')) {
    function getTaxFilters($filters) {
        $filter_terms = collect([]);
        if(isset($filters)) :
            foreach ($filters as $filter) :
                if($filter['taxonomy_style']->value()->value() === 'nested') :
                    $taxonomies = (new \App\TaxonomyFilters)
                        ->withTerms()
                        ->withRecursiveTerms()
                        ->addTaxonomy($filter['taxonomy_to_filter_by']->value()->handle())
                        ->toCollection()->toArray();
                    $taxonomies[0]['style'] = $filter['taxonomy_style'];
                    $filter_terms->push(...$taxonomies);
                    // dd($filter_terms);
                else :
                    $term = (new \App\TaxonomyFilters($filter['taxonomy_to_filter_by']->value()->handle()))->withTerms()->toArray();
                    $term[0]['style'] = $filter['taxonomy_style'];
                    $filter_terms->push(...$term);
                endif;
            endforeach;
        endif;
    return $filter_terms;
    }
}

// Statamic get child Terms
if (!function_exists('getChildTerms')) {
    function getChildTerms($term, $taxonomy = "product_category") {
        return Term::query()->where('taxonomy', $taxonomy)->where('parent', $term->slug())->get() ?? collect([]);

        // If multiple terms can exist
        // return Term::query()->where('taxonomy', $taxonomy)->whereNotNull('parent')->get()->filter(function ($_) use ($term) {
        //     return is_string($term) ? $term : $term->slug() === $_->augmentedValue('parent')->value()->slug();
        //     // || $term->id() === $_->augmentedValue('parent')->value()->id()
        // }) ?? collect([]);
    }
}

if (!function_exists('getChildTermsRecursive')) {
    function getChildTermsRecursive($term, $taxonomy = "product_category") {
        $terms = getChildTerms($term, $taxonomy);

        $terms = $terms->map(function ($term) use ($taxonomy) {
            $term->children = getChildTermsRecursive($term, $taxonomy);
            return $term;
        });

        return $terms;
    }
}

if (!function_exists('getParentTerm')) {
    function getParentTerm($term) {
       return isset($term['parent']) ? optional($term['parent']->value())->toAugmentedArray() : null;
    }
}

if (!function_exists('getParentTerms')) {
    function getParentTerms($term) {
        $terms = [];

        $terms[] = getParentTerm($term);

        $parent = isset($term['parent']) ? optional($term['parent']->value())->toAugmentedArray() : null;


        if (isset($parent)) {
            $terms = array_merge($terms, getParentTerms($parent)->toArray());
        }

        return collect($terms)->filter()->reverse()->values();

    }
}

function getRootParentTerm($term) {
    $parent = getParentTerm($term);

    if (isset($parent)) {
        return getRootParentTerm($parent);
    }

    return $term;
}

if (!function_exists('product_breadcrumbs')) {
    function product_breadcrumbs($term, $current = null) {
        $prefix = collect([['url'=>'/', 'title' => 'Home'], ['url'=>'/products', 'title' => 'Products']]);
        $suffix = [$term];

        if(isset($current) && !empty($current)) {
            $suffix[] = ['url'=>false, 'title' => $current];
        }
        return sprintf("<nav class='product-breadcrumbs max-w-full overflow-auto flex items-center gap-4'>%s</nav>",
            $prefix->push(...getParentTerms($term))->push(...$suffix)->map(function ($subTerm) {
                $tag = $subTerm['url'] ? 'a' : 'span';
                $class = $subTerm['url'] ? '' : 'text-gray-700';
                $url = $subTerm['url'] ? "href='{$subTerm['url']}'" : null;
                $title = $subTerm['title'];
                return sprintf('<%s class="whitespace-nowrap %s" %s>%s</%s>',
                    $tag,
                    $class,
                    $url,
                    $title,
                    $tag,
                );
        })->implode(' <i class="fas fa-chevron-right"></i> '));
    }
}

if (!function_exists('getAugmentedAsset')) {
    function getAugmentedAsset($asset) {
        return Asset::find("assets::{$asset}")->toAugmentedCollection();
    }
}

if (!function_exists('taxonomy_link_list')) {
    function taxonomy_link_list(Value $taxonomy, string $ul_class = 'm-0 p-0', string $li_class = '') {
        if (!$taxonomy || $taxonomy->value()->isEmpty()) return;
        return "<ul class='{$ul_class}'>" . $taxonomy->value()->map(function($type) use ($li_class) {
            return sprintf("<li class='{$li_class}'><a href='%s'>%s</a></li>", $type->url(), $type->title());
        })->implode(',') . "</ul>";
    }
}

if (!function_exists('get_product_breadcrumbs')) {
    function get_product_breadcrumbs($term, $current = null) {
        $prefix = collect([['url'=>'/', 'title' => 'Home'], ['url'=>'/products', 'title' => 'Products']]);
        $suffix = [$term];

        if(isset($current)) {
            $suffix[] = ['url'=>false, 'title' => $current];
        }

        return $prefix->push(...getParentTerms($term))->push(...$suffix)->map(function ($subTerm) {
                $url = $subTerm['url'] ? $subTerm['url'] : null;
                $title = $subTerm['title'];
                return [
                    'url' => $url,
                    'title' => $title,
                ];
        });
    }
}

if (!function_exists('get_thumbnail')) {
    function get_thumbnail($thumbnail, $params = []) {
         $data = (new GlideTag)
                ->setParser(Antlers::parser())
                ->setContext([])
                ->setParameters($params)
                ->generate($thumbnail->value());

                // dd($data);
            return $data[0];
    }
}

