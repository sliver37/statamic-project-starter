<template>
    <swiper v-bind="sliderProps" v-if="defaultSlots">
        <swiper-slide
            v-for="(slot, index) in defaultSlots"
            :key="`vue-default-slot-${index}`"
        >
            <vnode :vnode="slot" />
        </swiper-slide>
        <div v-if="showNavigation">
            <div
                class="swiper-button-prev absolute top-1/2 -translate-y-1/2 left-0 fas fa-chevron-left"
                :class="`swiper-button-prev-${name}`"
            ></div>
            <div
                class="swiper-button-next absolute top-1/2 -translate-y-1/2 right-0 fas fa-chevron-right"
                :class="`swiper-button-next-${name}`"
            ></div>
        </div>
    </swiper>
</template>
<script>
// Import Swiper Vue.js components
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
    props: {
        showPagination: {
            type: Boolean,
            default: false,
        },
        showNavigation: {
            type: Boolean,
            default: false,
        },
        spaceBetween: {
            type: Number,
            default: 30,
        },
        slidesPerView: {
            type: Number,
            default: 2.5,
        },
        name: {
            type: String,
            default: "",
        },
        loop: {
            type: Boolean,
            default: true,
        },
        autoplay: {
            type: Boolean,
            default: false,
        },
    },
    setup(
        {
            showPagination,
            showNavigation,
            spaceBetween,
            slidesPerView,
            name,
            loop,
        },
        { slots }
    ) {
        const sliderProps = {
            spaceBetween: spaceBetween,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: slidesPerView,
                },
            },
            pagination: showPagination,
            navigation: {
                nextEl: `.swiper-button-next-${name}`,
                prevEl: `.swiper-button-prev-${name}`,
            },
            autoplay: {
                delay: 3000,
            },
            loop,
        };

        const defaultSlots = (slots.default() || []).reduce((acc, cur) => {
            if (String(cur.type).includes("Symbol")) {
                if (cur.children) {
                    acc.push(...cur.children);
                }
            } else {
                acc.push(cur);
            }
            return acc;
        }, []);

        return {
            defaultSlots,
            name,
            showPagination,
            showNavigation,
            sliderProps,
        };
    },
};
</script>

<style lang="scss">
.swiper {
    @apply flex flex-col;
}

.swiper-button-next,
.swiper-button-prev {
    position: static;
    width: auto;
    height: auto;
    margin: 0;
}

.swiper-button-next.swiper-button-disabled,
.swiper-button-prev.swiper-button-disabled {
    opacity: 0.35;
    cursor: auto;
    pointer-events: none;
}

.swiper-button-next:after,
.swiper-button-prev:after {
    display: none;
}

.swiper-button-next,
.swiper-button-prev {
    &:before {
        @apply drop-shadow text-white text-3xl p-4;
    }

    &::after,
    &::after {
        @apply hidden;
    }
}

.swiper-button-next,
.swiper-button-prev {
    &:hover {
        cursor: pointer;
    }
    &:not(.swiper-button-disabled) {
        color: var(--color-primary);
    }
}

.swiper-button-prev,
.swiper-container-rtl .swiper-button-next {
    left: unset;
    right: unset;
}

.swiper-button-prev:after,
.swiper-container-rtl .swiper-button-next:after {
    content: "prev";
}

.swiper-button-next,
.swiper-container-rtl .swiper-button-prev {
    right: unset;
    left: unset;
}

.swiper-button-next:after,
.swiper-container-rtl .swiper-button-prev:after {
    content: "next";
}

.swiper-button-next.swiper-button-white,
.swiper-button-prev.swiper-button-white {
    --swiper-navigation-color: #ffffff;
}

.swiper-button-next.swiper-button-black,
.swiper-button-prev.swiper-button-black {
    --swiper-navigation-color: #000000;
}

.swiper-button-lock {
    display: none;
}

.swiper-horizontal > .swiper-pagination-bullets,
.swiper-pagination-bullets.swiper-pagination-horizontal,
.swiper-pagination-custom,
.swiper-pagination-fraction {
    @apply order-2 static mt-4;
}

.swiper-wrapper {
    order: 1;
}
</style>

<style lang="scss" scoped>
.swiper-slide {
    @apply flex flex-grow h-auto;
}
</style>
