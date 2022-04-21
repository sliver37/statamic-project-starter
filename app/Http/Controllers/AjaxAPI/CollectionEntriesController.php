<?php

namespace App\Http\Controllers\AjaxAPI;

use Statamic\Facades\Search;
use Statamic\Facades\Entry;
use Statamic\Http\Resources\API\EntryResource;

class CollectionEntriesController extends \Statamic\Http\Controllers\API\CollectionEntriesController
{
    protected $collection;

    public function index($collection)
    {
        $this->abortIfDisabled();

        $this->collection = $collection;

        return app(EntryResource::class)::collection(
            $this->findResults($collection->queryEntries())
        );
    }

    /**
     * search, filter, sort, and paginate our way to victory!
     *
     * @param \Statamic\Query\Builder $query
     *
     * @return \Statamic\Extensions\Pagination\LengthAwarePaginator
     */
    protected function findResults($query)
    {
        // $search = $this->search($query)->filterTaxonomies($query)->filterSortAndPaginate($query);

        // dd($search);

        return $this
            ->search($query)
            ->filterTaxonomies($query)
            ->filterSortAndPaginate($query);
            // ->filterProjectEquipment($query); // Ideally this would be "filterFields" so we could make this flexible and allow for custom filtering
        }

    protected function search($query)
    {
        $q = request()->get('q');

        if (!empty($q) && Search::indexes()->has($this->collection->handle())) {
            $search = Search::index($this->collection->handle())->search($q)->get();

            if ($search->isNotEmpty()) {
                $query->whereIn('id', $search->map->id()->toArray());
            } else {
                $query->where('id', null);
            }
        }

        return $this;
    }

    protected function filterTaxonomies($query)
    {
        $taxonomies = request()->get('taxonomies');


        if (!empty($taxonomies) && is_array($taxonomies)) {
            $taxonomyTerms = collect([]);

            foreach ($taxonomies as $taxonomy => $terms) {
                $termList = explode('|', $terms);
                foreach ($termList as $term) {
                    // $taxonomyTerms->push("{$taxonomy}::{$term}");
                    $taxonomyTerms->push(modify($term)->ensureLeft("{$taxonomy}::")->__toString());
                }
            }

            if ($taxonomyTerms->isNotEmpty()) {
                $query->whereTaxonomyIn($taxonomyTerms->toArray());
            }
        }

        return $this;
    }

    // protected function filterProjectEquipment($query)
    // {

    //     $taxonomies = request()->get('equipment_used');

    //     /***** Get all projects that have products which match the selected product categories *****/
    //      if (!empty($taxonomies) && is_array($taxonomies)) {
    //         $taxonomyTerms = collect([]);

    //         foreach ($taxonomies as $taxonomy => $terms) {
    //             $termList = explode('|', $terms);
    //             foreach ($termList as $term) {
    //                 // As we are filtering on higher-level taxonomies, we need to dig down to the child-most ones to ensure all products are included
    //                 $childTerms = getChildTerms($term);
    //                 $taxonomyTerms->push(...collect(($childTerms)->toAugmentedCollection())->pluck('id')->toArray());
    //             }
    //         }

    //         // Query 1 - Get all product IDs from selected product_category
    //         $product_ids = collect(Entry::query()->where('collection', 'products')
    //             ->whereTaxonomyIn([...$taxonomyTerms->toArray()])
    //             ->get()->toAugmentedCollection())
    //             ->pluck('id');

    //         // Query 2 - Get all projects that have equipment_used that match products in the selected product categories
    //         if ($product_ids->isNotEmpty()) {
    //             $results = $query
    //             ->where('collection', 'projects')
    //             ->whereNotNull('equipment_used')
    //             ->get()
    //             ->filter(function ($_) use ($product_ids) {
    //                 return array_intersect($_->equipment_used, $product_ids->toArray());
    //             }) ?? collect([]);
    //         }

    //         // No idea how to keep this as $query when we need to do the above ->get and ->filter step :(
    //         dd($results);
    //     }

    // }

    /**
     * Gets a paginator, limited if requested by the limit paramter.
     *
     * /endpoint?limit=10
     *
     * @param \Statamic\Query\Builder $query
     *
     * @return \Statamic\Extensions\Pagination\LengthAwarePaginator
     */
    protected function paginate($query)
    {
        $columns = explode(',', request()->input('fields', '*'));

        return $query
            ->paginate(request('limit', 6), $columns)
            ->appends(request()->only(['filter', 'limit', 'page', 'q', 'taxonomies']));
    }
}
