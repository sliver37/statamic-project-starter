<?php

namespace App;

use Illuminate\Support\Collection;
use Statamic\Contracts\Taxonomies\Taxonomy;
use Statamic\Contracts\Taxonomies\Term;
use Statamic\Facades\Taxonomy as TaxonomyFacade;
use Statamic\Facades\Term as TermFacade;
use Statamic\Taxonomies\TermCollection;

class TaxonomyFilters
{
    protected $taxonomies;
    protected $withTerms = false;
    protected $withRecursiveTerms = false;

    public function __construct(array | Collection | string | Taxonomy $taxonomies = null, bool $withTerms = false, bool $withRecursiveTerms = false)
    {
        $this->taxonomies = collect([]);
        $this->withTerms = $withTerms;
        $this->withRecursiveTerms = $withRecursiveTerms;

        $this->addTaxonomy($taxonomies);
    }

    public function addTaxonomy(array | Collection | string | Taxonomy $taxonomies = null): static
    {
        if ($taxonomies instanceof Taxonomy) {
            $taxonomies = [$taxonomies->id()];
        } elseif ($taxonomies instanceof Collection) {
            $taxonomies = $taxonomies->all();
        } elseif (is_string($taxonomies)) {
            $taxonomies = explode(',', $taxonomies);
        }

        collect($taxonomies)->map(function ($taxonomy) {
            if ($taxonomy instanceof Taxonomy) {
                return $this->taxonomies->push($taxonomy);
            } elseif (is_string($taxonomy) && $_taxonomy = \Statamic\Facades\Taxonomy::find(trim($taxonomy))) {
                return $this->taxonomies->push($_taxonomy);
            } elseif (is_array($taxonomy) || $taxonomy instanceof Collection) {
                return $this->addTaxonomy($taxonomy);
            }
        });

        return $this;
    }

    public function withTerms(bool $withTerms = true): static
    {
        $this->withTerms = $withTerms;

        return $this;
    }

    public function withRecursiveTerms(bool $withRecursiveTerms = true): static
    {
        $this->withRecursiveTerms = $withRecursiveTerms;

        return $this;
    }

    public function toCollection(): Collection
    {
        if ($this->taxonomies->isEmpty()) {
            $this->addTaxonomy(TaxonomyFacade::all());
        }

        return $this->taxonomies->map(function ($taxonomy) {
            $data = [
                'id' => $taxonomy->id(),
                'title' => $taxonomy->title(),
                'content' => $taxonomy->augmentedValue('content'),
            ];

            if ($this->withTerms) {
                $terms = [];

                $termCollection = $taxonomy->queryTerms()->orderBy('display_order')->get();

                if ($this->withRecursiveTerms) {
                    $termCollection = $termCollection->map(function ($term) {
                        return [
                                'term' => $term,
                                'parent' => $term->get('parent'),
                            ];
                    });
                    $termCollection->where('parent', null)->each(function ($_) use ($termCollection, &$terms) {
                        $terms[$_['term']->id()]['id'] = $_['term']->id();
                        $terms[$_['term']->id()]['slug'] = $_['term']->slug();
                        $terms[$_['term']->id()]['title'] = $_['term']->title();
                        $terms[$_['term']->id()]['content'] = $_['term']->augmentedValue('content');

                        $nestedTerms = $termCollection->where('parent', $_['term']->slug());

                        if ($nestedTerms->isNotEmpty()) {
                            $terms['is_nested'] = true;
                            $terms[$_['term']->id()]['terms'] = $this->getTermsOfTerms($nestedTerms, $termCollection);
                        }
                    });
                } else {
                    $termCollection->each(function ($term) use (&$terms) {
                        $terms[$term->id()]['id'] = $term->id();
                        $terms[$term->id()]['slug'] = $term->slug();
                        $terms[$term->id()]['title'] = $term->title();
                        $terms[$term->id()]['content'] = $term->augmentedValue('content');
                    });
                }

                if (! empty($terms)) {
                    $data['terms'] = $terms;
                }
            }

            return $data;
        });
    }

    public function toArray(): array
    {
        return $this->toCollection()->toArray();
    }

    public function toJson(): string
    {
        return $this->toCollection()->toJson();
    }

    protected function getTermsOfTerms(Collection $terms, Collection $termCollection): array
    {
        $data = [];

        foreach ($terms as $_) {
            $data[$_['term']->id()] = [
                'id' => $_['term']->id(),
                'slug' => $_['term']->slug(),
                'title' => $_['term']->title(),
                'content' => $_['term']->augmentedValue('content'),
            ];

            $nestedTerms = $termCollection->where('parent', $_['term']->slug());

            if ($nestedTerms->isNotEmpty()) {
                $data[$_['term']->id()]['terms'] = $this->getTermsOfTerms($nestedTerms, $termCollection);
            }
        }

        return $data;
    }
}
