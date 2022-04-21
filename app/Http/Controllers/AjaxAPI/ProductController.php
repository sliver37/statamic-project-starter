<?php

namespace App\Http\Controllers\AjaxAPI;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function AjaxProducts(Request $request)
    {
        $pagination = 21;

        if (! empty($request->get('limit')) && $limit = $request->get('limit')) {
            $pagination = (int) $limit;
            $pagination = ($pagination > 0) ? $pagination : null;
        }

        $products = Entry::collection('products')->published();

        if ($request->has('filters') && $filters = $request->get('filters')) {
            if (! empty($filters['taxonomies'])) {
                $products->HasTaxonomy(explode(',', $filters['taxonomies']));
            }

            if (! empty($filters['terms'])) {
                $products->HasTaxonomyTerm(explode(',', $filters['terms']));
            }
        }

        if ($request->has('search') && $search = $request->get('search')) {
            $products->search($search);
        }

        $products = \Statamic\Facades\Entry::query()
            ->where('published', true)
            ->whereIn('id', $products->get('id')->pluck('id')->toArray())
            ->paginate($pagination);

        // no idea how to augment this -- The play experiences and play blog pages both have a console log with the response.
        // At the moment data array is the correct length but each item is empty

        // You can use any of the below, ->map-> might need to be replaced with the ->map(function($entry)) callback.
        // If you want to set the data on pagination, use $products->setCollection(collect($anArrayOfSomething));

        return [
            'data' => $products->setCollection(collect($products->toAugmentedArray())),
            // 'map-augmented-map-all' => $activities->map->augmented()->map->all(),
            // 'map-cacheableArray' => $activities->map->toCacheableArray(),
            // 'map-entryFileData' => $activities->map->fileData(),
            // 'map-entryData' => $activities->map->data(),
            // 'map-values' => $activities->map->values(),
        ];
    }
}
