<template>
    <div
        class="max-w-full relative gap-3 items-center"
        :class="
            options.namespace +
            '-base-container scroller-at-' +
            options.scroller_position
        "
    >
        <!-- <i
            class="fas text-primary fa-search-plus absolute z-10 left-0 top-0 bg-white text-2xl p-1 bg-opacity-70 pointer-events-none"
        ></i> -->
        <div class="flex justify-center relative">
            <a class="outline-none" @click.prevent="movePrev" href="#"
                ><svg-vue
                    :icon="scroller_icon_first"
                    class="zoomer-control text-primary absolute top-1/2 -translate-y-1/2 left-0 flex-shrink-0 w-8 h-8 responsive-image"
                    alt="move thumb icon"
            /></a>
            <img
                :src="previewImg.url"
                :data-zoom="previewLargeImg.url"
                ref="preview_img_el"
                class="responsive-image flex-1 max-w-[90%] preview-box"
                draggable="false"
                :alt="previewImg.alt"
            />
            <a class="outline-none" @click.prevent="moveNext" href="#">
                <svg-vue
                    :icon="scroller_icon_second"
                    class="zoomer-control text-primary absolute top-1/2 -translate-y-1/2 right-0 flex-shrink-0 w-8 h-8 responsive-image"
                    alt="move thumb icon"
                />
            </a>
        </div>
        <div
            ref="thumbsContainer"
            class="thumb-list"
            :style="[thumbListStyles]"
            :class="[{ has_nav: show_nav }, show_nav ? 'w-4/5' : 'w-3/5']"
        >
            <a class="outline-none" @click.prevent="moveThumbs('prev')" href="#"
                ><svg-vue
                    v-if="show_nav"
                    :icon="scroller_icon_first"
                    class="zoomer-control w-6 h-6 responsive-image"
                    alt="move thumb icon"
            /></a>
            <img
                draggable="false"
                v-show="key < options.scroll_items"
                :key="key"
                :alt="thumb.alt"
                :src="thumb.url"
                @click="chooseThumb(thumb, $event)"
                v-for="(thumb, key) in thumbs"
                class="responsive-image flex-grow"
                v-bind:style="{
                    boxShadow:
                        thumb.id === choosedThumb.id
                            ? '0px 0px 0px 2px ' +
                              options.choosed_thumb_border_color
                            : '',
                }"
            />
            <a class="outline-none" @click.prevent="moveThumbs('next')" href="#"
                ><svg-vue
                    v-if="show_nav"
                    :icon="scroller_icon_second"
                    class="zoomer-control w-6 h-6 responsive-image"
                    alt="move thumb icon"
            /></a>
        </div>
        <div
            ref="painContainer"
            class="pane-container lg:w-full lg:h-full w-2/4 h-2/4 right-0 absolute top-0 lg:left-0 lg:right-auto lg:translate-x-full"
        ></div>
    </div>
</template>

<script>
import { useProductColour } from "../../composables/useProductColour";

import { reactive, ref, computed, watch, onMounted, nextTick } from "vue";
import Drift from "./assets/drift-zoom/src/js/Drift.js";

export default {
    name: "ProductZoomer",
    props: {
        baseZoomerOptions: {
            type: Object,
            default: function () {
                return {};
            },
        },
        baseImages: {
            type: Object,
            required: true,
            default: function () {
                return {};
            },
        },
    },
    async setup({ baseImages, baseZoomerOptions }) {
        const options = reactive({
            zoomFactor: 4,
            pane: "container",
            hoverDelay: 300,
            namespace: "container-zoomer",
            move_by_click: true,
            scroll_items: 4,
            choosed_thumb_border_color: "#ff3d00",
            scroller_button_style: "line",
            scroller_position: "bottom",
            zoomer_pane_position: "right",
            show_nav: true,
            ...baseZoomerOptions,
        });

        let previewImg = ref({});
        let previewLargeImg = ref({});

        let choosedThumb = ref({});
        const drift = ref(null);

        const { getColour, setColour } = useProductColour();

        const painContainer = ref(null);

        onMounted(() => {
            options.injectBaseStyles = true;

            if (options.pane === "container-round") {
                options.inlinePane = true;
            } else {
                options.inlinePane = false;
                options.paneContainer = painContainer.value;
            }

            drift.value = new Drift(preview_img_el.value, options);

            chooseThumb(image_sizes["thumbs"][0]);

            if (
                options.pane === "container-round" ||
                options.pane === "container"
            ) {
                options.hoverBoundingBox = false;
            } else {
                options.hoverBoundingBox = true;
            }
        });

        const image_sizes = reactive({
            thumbs: [],
            normal_size: [],
            large_size: [],
        });

        image_sizes.thumbs = await getImages(baseImages, [200, 200]);
        image_sizes.normal_size = await getImages(baseImages, [400, 400]);
        image_sizes.large_size = await getImages(baseImages);

        const preview_img_el = ref(null);

        const scroller_icon_first = computed(() => {
            return "arrow-left-s-line";
        });
        const scroller_icon_second = computed(() => {
            return "arrow-right-s-line";
        });

        const show_nav = computed(() => {
            return options.show_nav && image_sizes["thumbs"].length > 3;
        });

        const currentIndex = computed(() => {
            return image_sizes["thumbs"].findIndex(
                (el) => el.id === choosedThumb.value.id
            );
        });

        watch(getColour, (val) => {
            const findIndex = image_sizes["thumbs"].findIndex(
                (el) =>
                    el?.colour_option && el.colour_option === val?.colour_option
            );

            if (findIndex !== -1) {
                choosedThumb.value = image_sizes["thumbs"][findIndex];
            }

            if (val?.external) {
                moveThumbs("goTo", findIndex);
            }
        });

        async function getImg(url, size = [200, 200]) {
            const sizeString = size.length
                ? `?w=${size[0]}&h=${size[1]}&fit=crop`
                : "";
            const res = await fetch(`/img${url}${sizeString}`)
                .then((res) => res.url)
                .catch((err) => console.log(err));
            return res;
        }

        async function getImages(images, size = []) {
            const promises = await Promise.all(
                images.map(async (img) => {
                    const res = await getImg(img.url, size);
                    return {
                        id: img.id,
                        url: res,
                        alt: img.alt,
                        colour_option: img?.colour_option?.slug || null,
                    };
                })
            );

            return [...promises];
        }

        const movePrev = () => {
            if (currentIndex.value > 0) {
                chooseThumb(image_sizes["thumbs"][currentIndex.value - 1]);
            } else {
                chooseThumb(
                    image_sizes["thumbs"][image_sizes["thumbs"].length - 1]
                );
            }
        };

        const moveNext = () => {
            if (currentIndex.value + 1 !== image_sizes["thumbs"].length) {
                chooseThumb(image_sizes["thumbs"][currentIndex.value + 1]);
            } else {
                chooseThumb(image_sizes["thumbs"][0]);
            }
        };

        // Thumbs Stuff
        const thumbsContainer = ref(null);
        const thumbs = computed(() => image_sizes["thumbs"]);
        const show_thumbs = computed(() => {
            return thumbs.value.length > 1;
        });
        const thumbListStyles = computed(() => {
            if (!thumbsContainer.value) {
                return;
            }
            const scrollerItemsCount =
                parseInt(baseZoomerOptions.scroll_items) + 2;
            return show_nav.value
                ? thumbsContainer.value.setAttribute(
                      "style",
                      "grid-template-columns:calc(100%/" +
                          scrollerItemsCount +
                          "/2) repeat(" +
                          (scrollerItemsCount - 2) +
                          ", auto) calc(100%/" +
                          scrollerItemsCount +
                          "/2);visibility:visible;"
                  )
                : thumbsContainer.value.setAttribute(
                      "style",
                      `grid-template-columns: repeat(${
                          image_sizes["thumbs"].length < 4
                              ? image_sizes["thumbs"].length
                              : 4
                      }, 1fr);`
                  );
        });

        watch(choosedThumb, (thumb) => {
            let matchNormalImg = image_sizes["normal_size"].find((img) => {
                return img.id === thumb.id;
            });
            let matchLargeImg = image_sizes["large_size"].find((img) => {
                return img.id === thumb.id;
            });
            previewLargeImg.value = Object.assign({}, matchLargeImg);
            previewImg.value = Object.assign({}, matchNormalImg);
            if (drift.value !== null) {
                drift.value.setZoomImageURL(matchLargeImg.url);
            }
        });

        const thumbDirections = {
            next() {
                const moveThumb = image_sizes["thumbs"].splice(0, 1);
                image_sizes["thumbs"] = [
                    ...image_sizes["thumbs"],
                    moveThumb[0],
                ];
            },
            prev() {
                const moveThumb = image_sizes["thumbs"].splice(
                    image_sizes["thumbs"].length - 1,
                    1
                );
                image_sizes["thumbs"] = [
                    moveThumb[0],
                    ...image_sizes["thumbs"],
                ];
            },
            goTo(index) {
                const moveThumb = image_sizes["thumbs"].splice(index, 1);
                image_sizes["thumbs"] = [
                    moveThumb[0],
                    ...image_sizes["thumbs"],
                ];
            },
        };

        const moveThumbs = (direction, index = null) => {
            if (!show_thumbs) {
                return;
            }
            thumbDirections[direction](index);
        };

        const chooseThumb = (thumb, event = { type: "click" }) => {
            if (!show_thumbs) {
                return;
            }

            if (thumb?.colour_option) {
                setColour({
                    colour_option: thumb.colour_option,
                });
            }

            if (event.type === "mouseover") {
                if (!options.move_by_click) {
                    choosedThumb.value = thumb;
                }
            } else {
                choosedThumb.value = thumb;
            }
        };

        return {
            painContainer,
            thumbsContainer,
            thumbListStyles,
            options,
            movePrev,
            moveNext,
            show_thumbs,
            moveThumbs,
            thumbs,
            show_nav,
            choosedThumb,
            previewImg,
            preview_img_el,
            previewLargeImg,
            chooseThumb,
            scroller_icon_first,
            scroller_icon_second,
        };
    },
};
</script>
<style>
@import "./assets/drift-zoom/src/css/drift-basic.css";
</style>

<style scoped>
.scroller-at-bottom {
    display: grid;
    grid-gap: 2px;
    grid-template-columns: 1fr;
    align-items: center;
}

.scroller-at-bottom .thumb-list {
    display: grid;
    gap: 2rem;
}

.scroller-at-bottom .thumb-list.has_nav {
    display: grid;
    align-items: center;
    grid-column-gap: 0.2em;
    grid-column: 1 / 2;
    grid-row: 2 / 3;
}

.zoomer-control {
    cursor: pointer;
}
.choosed-thumb {
    border-radius: 0px;
}
.pane-container {
    display: none;
    position: absolute;
    z-index: 10000;
    pointer-events: none;
}
</style>
