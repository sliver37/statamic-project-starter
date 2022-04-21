<template>
    <div v-if="totalPages > 1">
        <section
            class="flex flex-col md:flex-row items-center justify-center lg:justify-between bg-white rounded-lg shadow px-10 py-3 text-textmain"
        >
            <ul class="flex flex-row gap-1 md:gap-3 mb-4 md:m-0 items-center">
                <li v-if="hasPrev">
                    <a href="#" @click.prevent="changePage(prevPage)">
                        <div
                            class="flex items-center justify-center hover:bg-gray-200 rounded-md transform rotate-45 h-6 w-6"
                        >
                            <div class="transform -rotate-45">
                                <svg
                                    class="h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 19l-7-7 7-7"
                                    />
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>
                <li v-if="hasFirst">
                    <a href="#" @click.prevent="changePage(1)">
                        <div
                            class="flex hover:bg-gray-200 rounded-md transform rotate-45 h-6 w-6 items-center justify-center"
                        >
                            <span class="transform -rotate-45"> 1 </span>
                        </div>
                    </a>
                </li>
                <li v-if="hasFirst">...</li>
                <li v-for="page in pages" :key="'pagination' + page">
                    <a href="#" @click.prevent="changePage(page)">
                        <div
                            :class="{
                                'text-textmain border-b border-secondary':
                                    current == page,
                            }"
                            class="flex hover:bg-gray-200 border-b transform h-6 w-6 items-center justify-center"
                        >
                            <span class="transform">{{ page }}</span>
                        </div>
                    </a>
                </li>
                <li v-if="hasLast">...</li>
                <li v-if="hasLast">
                    <a href="#" @click.prevent="changePage(totalPages)">
                        <div
                            class="flex hover:bg-gray-200 rounded-md transform rotate-45 h-6 w-6 items-center justify-center"
                        >
                            <span class="transform -rotate-45">
                                {{ totalPages }}
                            </span>
                        </div>
                    </a>
                </li>
                <li v-if="hasNext">
                    <a href="#" @click.prevent="changePage(nextPage)">
                        <div
                            class="flex items-center justify-center hover:bg-gray-200 rounded-md transform rotate-45 h-6 w-6"
                        >
                            <div class="transform -rotate-45">
                                <svg
                                    class="h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>

            <div class="flex items-center justify-center lg:justify-end">
                <div class="pr-2 font-medium">
                    <span id="text-before-input">
                        {{ textBeforeInput }}
                    </span>
                </div>
                <div class="w-1/5 rounded-md shadow py-1">
                    <input
                        v-model.number="input"
                        class="focus:outline-none"
                        type="text"
                    />
                </div>
                <div
                    @click.prevent="changePage(input)"
                    class="flex items-center pl-4 font-medium cursor-pointer"
                >
                    <span id="text-after-input">
                        {{ textAfterInput }}
                    </span>
                    <svg
                        class="h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { isAbove } from "../../functions/breakpoints";
import { defineComponent, ref, computed, toRefs, onMounted } from "vue";

export default defineComponent({
    name: "v-pagination",
    props: {
        pagination: {
            type: Object,
            required: true,
        },
        pageRange: {
            type: Number,
            default: 4,
        },
        textBeforeInput: {
            type: String,
            default: "Go to page",
        },
        textAfterInput: {
            type: String,
            default: "Go",
        },
    },
    emits: ["page-changed"],
    setup(props, context) {
        const { pageRange, textBeforeInput, textAfterInput } = props;

        const responsiveRange = ref(pageRange);

        const { pagination } = toRefs(props);

        const input = ref("");

        const rangeStart = computed(() => {
            var start = pagination.value.current_page - responsiveRange.value;
            return start > 0 ? start : 1;
        });
        const rangeEnd = computed(() => {
            var end = pagination.value.current_page + responsiveRange.value;
            return end < totalPages.value ? end : totalPages.value;
        });

        const pages = computed(() => {
            var pages = [];
            for (var i = rangeStart.value; i <= rangeEnd.value; i++) {
                pages.push(i);
            }
            return pages;
        });

        const totalPages = computed(() => {
            return Math.ceil(
                pagination.value.total / pagination.value.per_page
            );
        });

        const current = computed(() => {
            return pagination.value.current_page;
        });

        const nextPage = computed(() => {
            return current.value + 1;
        });

        const prevPage = computed(() => {
            return current.value - 1;
        });

        const hasFirst = computed(() => {
            return rangeStart.value !== 1;
        });

        const hasLast = computed(() => {
            return rangeEnd.value < totalPages.value;
        });

        const hasPrev = computed(() => {
            return current.value > 1;
        });

        const hasNext = computed(() => {
            return current.value < totalPages.value;
        });

        const changePage = (page) => {
            if (page > totalPages.value) {
                input.value = totalPages.value;
                return context.emit("page-changed", input.value);
            }

            if (page < 1) {
                input.value = 1;
                return context.emit("page-changed", input.value);
            }

            return context.emit("page-changed", page);
        };

        onMounted(() => {
            if (!isAbove.lg.matches) {
                responsiveRange.value = 1;
            }

            isAbove.lg.addEventListener("change", (e) => {
                if (e.matches) {
                    responsiveRange.value = pageRange;
                } else {
                    responsiveRange.value = 1;
                }
            });
        });

        return {
            current,
            prevPage,
            nextPage,
            hasFirst,
            hasLast,
            hasPrev,
            hasNext,
            pages,
            totalPages,
            input,
            changePage,
            textBeforeInput,
            textAfterInput,
        };
    },
});
</script>

<style scoped></style>
