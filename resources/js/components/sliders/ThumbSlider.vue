<template>
    <div>
        <swiper
            class="mb-8"
            :style="{
                '--swiper-navigation-color': '#fff',
                '--swiper-pagination-color': '#fff',
            }"
            :spaceBetween="10"
            :thumbs="{ swiper: thumbsSwiper }"
        >
            <swiper-slide
                class="h-auto"
                v-for="(slot, index) in defaultSlots"
                :key="`vue-default-slot-${index}`"
            >
                <vnode :vnode="slot" />
            </swiper-slide>
        </swiper>
        <div class="relative">
            <swiper
                class="swiper-thumbs w-4/6 md:w-5/6"
                @swiper="setThumbsSwiper"
                v-bind="sliderProps"
                v-if="defaultSlots"
            >
                <swiper-slide
                    class="h-auto"
                    v-for="(slot, index) in defaultSlots"
                    :key="`vue-default-slot-${index}`"
                >
                    <vnode :vnode="slot" />
                </swiper-slide>
            </swiper>
            <div
                class="swiper-button-prev absolute left-0 top-0 bottom-0 fas fa-chevron-left"
            ></div>
            <div
                class="swiper-button-next absolute right-0 top-0 bottom-0 fas fa-chevron-right"
            ></div>
        </div>
    </div>
</template>
<script>
// Import Swiper Vue.js components
import { ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import SwiperCore, { FreeMode, Navigation, Thumbs } from "swiper";

SwiperCore.use([FreeMode, Navigation, Thumbs]);

// Import Swiper styles
import "swiper/css";

import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    setup(props, { slots }) {
        let thumbsSwiper = ref(null);
        const sliderProps = {
            spaceBetween: 20,
            breakpoints: {
                0: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 6,
                },
            },
            freeMode: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            watchSlideProgress: true,
            ...props,
        };

        const defaultSlots = (
            (slots?.default && slots?.default()) ||
            []
        ).filter((slot) => !String(slot.type).includes("Symbol"));

        const setThumbsSwiper = (swiper) => (thumbsSwiper.value = swiper);

        return {
            thumbsSwiper,
            defaultSlots,
            sliderProps,
            setThumbsSwiper,
        };
    },
};
</script>

<style lang="scss">
.swiper-thumbs {
    .caption {
        @apply hidden;
    }
}
</style>
