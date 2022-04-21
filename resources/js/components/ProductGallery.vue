<template>
    <Suspense>
        <template #default>
            <ProductZoomer
                :base-images="images"
                :base-zoomer-options="zoomerOptions"
            />
        </template>
        <template #fallback>
            <div class="flex animate-pulse flex-col gap-6">
                <div class="preview-img bg-lightgray h-96"></div>
                <ul class="m-0 grid gap-3 grid-cols-4">
                    <li class="bg-lightgray h-32"></li>
                    <li class="bg-lightgray h-32"></li>
                    <li class="bg-lightgray h-32"></li>
                    <li class="bg-lightgray h-32"></li>
                </ul>
            </div>
        </template>
    </Suspense>
</template>

<script>
export default {
    props: {
        images: {
            type: Array,
            required: true,
            default: [],
        },
    },
    setup({ images }) {
        const zoomerOptions = {
            zoomFactor: 3, // scale for zoomer
            pane: "pane", // three type of pane ['pane', 'container-round', 'container']
            hoverDelay: 300, // how long after the zoomer take effect
            namespace: "zoomer", // add a namespace for zoomer component, useful when on page have mutiple zoomer
            move_by_click: true, // move image by click thumb image or by mouseover
            scroll_items: 4, // thumbs for scroll
            choosed_thumb_border_color: "#bbdefb", // choosed thumb border color
            scroller_button_style: "line",
            scroller_position: "bottom",
            zoomer_pane_position: "right",
        };

        return {
            images,
            zoomerOptions,
        };
    },
};
</script>

<style></style>
