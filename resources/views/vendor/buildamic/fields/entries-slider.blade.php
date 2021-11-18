@extends('buildamic::layouts.field')

@section('field_content')
    @php
        $slider = $field->value()->value();
        $collection = $slider->get('collection');
        $template = $slider->get('template');
        $sliderType = $slider->has('slide_style')? "vue-slider-{$slider->get('slide_style')}" : 'vue-slider';

        if(! empty($collection)){
            $items = \Statamic\Facades\Entry::query()->where('collection', $collection)->where('published', true);

            $taxonomies = request()->get('taxonomies');

            if (! empty($taxonomies) && is_array($taxonomies)) {
                $taxonomyTerms = collect([]);

                foreach ($taxonomies as $taxonomy => $terms) {
                    $termList = explode('|', $terms);
                    foreach ($termList as $term) {
                        $taxonomyTerms->push(modify($term)->ensureLeft("{$taxonomy}::")->__toString());
                    }
                }

                if ($taxonomyTerms->isNotEmpty()) {
                    $items = $items->whereTaxonomyIn($taxonomyTerms->toArray());
                }
            }

            $items = $items->orderBy('date', 'desc')->limit(10)->get();
        }else{
            $items = collect([]);
        }
    @endphp
    @if(! empty($collection))
        @if($items->isEmpty())
        @else
            <vue-slider :slides-per-view="3" :space-between="0">
                @data($items)
                    @foreach($data as $slide)
                    <div class="opacity-0 max-h-0">
                      <x-dynamic-component :entry="$slide" :component="substr($template, strrpos($template, '/' )+1)" />
                    </div>
                    @endforeach
                @enddata
            </vue-slider>
        @endif
    @else
    @php
        $slides = collect(optional($slider->augmentedValue('slides'))->value() ?? [])->toJson();
    @endphp
        <{{ $sliderType }} @if($slider->has('slides')) :slides="{{ $slides }}" @endif ></{{ $sliderType }}>
    @endif
@overwrite
