<?php

namespace App\Http\Controllers\AjaxAPI;

use App\Http\Controllers\Controller;
use App\TaxonomyFilters;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    public function AjaxTaxonomyTerms(Request $request)
    {
        if ($request->has('taxonomies')) {
            if (! empty($request->get('taxonomies'))) {
                $filters = explode(',', $request->get('taxonomies'));

                // dd($filters);

                $taxonomies = new TaxonomyFilters($filters);
            }
        } else {
            $taxonomies = new TaxonomyFilters(\Statamic\Facades\Taxonomy::all());
        }

        if ($request->has('withTerms') && $request->get('withTerms') === 'true') {
            $taxonomies = $taxonomies->withTerms();
        }

        return $taxonomies->toJson();
    }
}
