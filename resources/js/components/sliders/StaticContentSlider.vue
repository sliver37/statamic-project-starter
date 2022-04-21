<template>
    <div>
        <div class="buildamic-row pb-0">
            <div
                v-if="content"
                class="buildamic-column md:col-4 flex flex-col items-center justify-center bg-white relative z-10"
            >
                <div v-html="content" />
                <div
                    class="flex mt-6 relative md:top-12 items-center justify-center gap-4"
                >
                    <div class="flex flex-shrink-0 gap-2 px-6 pb-6 md:p-0">
                        <div
                            class="swiper-button-prev las la-arrow-left"
                            :class="`swiper-button-prev-${name}`"
                        ></div>
                        <div
                            class="swiper-button-next las la-arrow-right"
                            :class="`swiper-button-next-${name}`"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="buildamic-column md:col-8">
                <swiper class="pt-14" v-bind="sliderProps" v-if="defaultSlots">
                    <swiper-slide
                        v-for="(slot, index) in defaultSlots"
                        :key="`vue-default-slot-${index}`"
                    >
                        <vnode :vnode="slot" />
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </div>
</template>
<script>
// Import Swiper Vue.js components
import { ref, onMounted } from "vue";
import SwiperCore, { Navigation } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";

SwiperCore.use([Navigation]);

import "swiper/css";
import "swiper/css/navigation";

export default {
    props: {
        content: {
            type: String,
            default: "",
        },
        perPage: {
            type: Number,
            default: 1.5,
        },
        name: {
            type: String,
            default: "",
        },
    },
    components: {
        Swiper,
        SwiperSlide,
    },
    setup({ content, perPage, name }, { slots }) {
        const init = ref(false);
        const sliderProps = {
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                981: {
                    slidesPerView: perPage,
                    spaceBetween: 30,
                },
            },
            loop: false,
            autoplay: true,
            navigation: {
                nextEl: `.swiper-button-next-${name}`,
                prevEl: `.swiper-button-prev-${name}`,
            },
        };

        const defaultSlots = (slots.default() || []).filter(
            (slot) => !String(slot.type).includes("Symbol")
        );

        return {
            content,
            name,
            defaultSlots,
            sliderProps,
        };
    },
};
</script>

<style lang="scss" scoped>
.swiper-slide {
    @apply flex flex-grow h-auto;
}
</style>
