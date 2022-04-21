
    @if(!empty($product_gallery))
        <product-gallery :images="{{ json_encode($product_gallery) }}"></product-gallery>
    @else
        <img class="shadow h-auto" src="/assets/woocommerce-placeholder.png" />
    @endif
