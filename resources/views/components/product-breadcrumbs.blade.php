@php
    $breadcrumbs = get_product_breadcrumbs($term, $current ?? null);
@endphp

@push('pre-styles')
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
                @foreach($breadcrumbs as $key=>$val)
                {
                    "@type": "ListItem",
                    "position": {{ $key+1 }},
                    "name": "{{ $val['title'] }}",
                    "item": "{{ $val['url'] }}"
                }
                @endforeach
            ]
        }
    </script>
@endpush

{!! product_breadcrumbs($term, $current ?? null) !!}
