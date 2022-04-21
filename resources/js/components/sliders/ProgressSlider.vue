<template>
    <div>
        <swiper v-bind="sliderProps" v-if="defaultSlots">
            <swiper-slide
                v-for="(slot, index) in defaultSlots"
                :key="`vue-default-slot-${index}`"
            >
                <vnode :vnode="slot" />
            </swiper-slide>
            <div class="flex mt-6 items-center gap-4">
                <div class="flex flex-shrink-0 gap-2 px-6 pb-6 md:p-0">
                    <div class="swiper-button-prev las la-arrow-left"></div>
                    <div class="swiper-button-next las la-arrow-right"></div>
                </div>
                <div class="swiper-pagination swiper-pagination-progressbar">
                    <span class="swiper-pagination-progressbar-fill"></span>
                </div>
            </div>
        </swiper>
    </div>
</template>
<script>
// Import Swiper Vue.js components
import { ref } from "vue";
import SwiperCore, { Pagination, Navigation } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";

SwiperCore.use([Pagination, Navigation]);

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    setup(props, { slots }) {
        const init = ref(false);
        const sliderProps = {
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2.3,
                    spaceBetween: 30,
                },
            },
            pagination: { el: ".swiper-pagination", type: "progressbar" },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            ...props,
        };

        const defaultSlots = (slots.default() || []).filter(
            (slot) => !String(slot.type).includes("Symbol")
        );

        return {
            defaultSlots,
            sliderProps,
        };
    },
};
</script>

<style>
.swiper-container
    .swiper-pagination-progressbar
    .swiper-pagination-progressbar-fill {
    --swiper-pagination-color: var(--color-primary);
}
</style>

<style lang="scss" scoped>
.swiper-slide {
    @apply flex flex-grow h-auto;
}

.swiper-pagination {
    @apply static;
    &-progressbar {
        @apply relative bottom-0 h-[2px] block w-full bg-[#E1E1E1];
    }
}

.swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
    background: rgb(206, 0, 0) !important;
}
</style>
