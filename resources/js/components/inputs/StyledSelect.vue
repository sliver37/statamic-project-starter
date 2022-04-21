<template>
    <div @keydown.escape="closeDropdown" class="space-y-1">
        <input class="hidden" type="text" :name="name" :value="selected" />
        <label
            id="listbox-label"
            class="block text-sm leading-5 font-medium text-gray-700"
        >
            <slot name="SelectLabel"></slot>
        </label>

        <div class="relative" v-click-outside="closeDropdown">
            <span class="inline-block w-full shadow-sm">
                <button
                    type="button"
                    @click="openDropdown"
                    @focus="openDropdown"
                    aria-haspopup="listbox"
                    aria-expanded="true"
                    aria-labelledby="listbox-label"
                    tabindex="0"
                    class="cursor-pointer relative w-full min-w-[10rem] text-left focus:outline-none focus:shadow-outline-blue border-lightgray focus:border-blue-300 transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                    style="
                        padding: var(--form-field-padding-y)
                            var(--form-field-padding-x);
                    "
                >
                    <div class="flex items-center space-x-3">
                        <span class="block truncate border-none p-0">
                            {{ selected.title }}
                        </span>
                    </div>
                    <span
                        class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none border-none"
                    >
                        <i
                            class="transform las la-angle-right rotate-90 text-lg transition-transform"
                            :class="[isOpen ? 'rotate-0' : 'rotate-90']"
                        />
                    </span>
                </button>
            </span>

            <!-- Select popover, show/hide based on select state. -->
            <div
                v-show="isOpen"
                class="absolute min-w-fit z-[1000] mt-1 w-full rounded-md bg-white shadow-lg"
            >
                <ul
                    tabindex="-1"
                    role="listbox"
                    aria-labelledby="listbox-label"
                    aria-activedescendant="listbox-item-3"
                    class="max-h-56 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5 m-0"
                >
                    <!--
            Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.
            Highlighted: "text-white bg-indigo-600", Not Highlighted: "text-gray-900"
          -->
                    <li @click="select(null)" class="py-2 pl-3 pr-9">
                        <div class="space-x-3">
                            <span class="block truncate cursor-pointer"
                                >All</span
                            >
                        </div>
                    </li>
                    <li
                        tabindex="0"
                        @click="select(option)"
                        @keydown.space.prevent="select(option)"
                        id="listbox-item-0"
                        role="option"
                        v-for="option in data"
                        v-bind:key="option.id"
                        class="text-gray-900 select-none relative py-2 pl-3 pr-9 cursor-pointer hover:text-white hover:bg-indigo-600 focus:outline-none focus:text-white focus:bg-indigo-600"
                    >
                        <div class="flex items-center space-x-3">
                            <span
                                class="block truncate"
                                v-bind:class="{
                                    'font-normal': !isSelected(option.id),
                                    'font-semibold': isSelected(option.id),
                                }"
                            >
                                {{ option.title }}
                            </span>
                        </div>

                        <!--
              Checkmark, only display for selected option.
              Highlighted: "text-white", Not Highlighted: "text-indigo-600"
            -->
                        <span
                            v-show="isSelected(option.id)"
                            class="absolute inset-y-0 right-0 flex items-center pr-4"
                        >
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </span>
                    </li>

                    <!-- More data... -->
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
    name: "styled-select",
    props: {
        name: String,
        data: [Array],
        value: {
            type: Object,
        },
    },
    emits: ["input", "callback"],
    setup({ data, value, name }, { emit }) {
        const isOpen = ref(false);
        const selected = ref({ id: "All", title: "All" });

        const isSelected = (val) => {
            return selected.value.id === val;
        };
        const closeDropdown = () => {
            isOpen.value = false;
        };
        const openDropdown = () => {
            isOpen.value = true;
        };
        const select = (item) => {
            if (item === null) {
                selected.value = { id: "All", title: "All" };
                isOpen.value = false;
                return emit("input", "");
            }

            isOpen.value = false;
            selected.value = item;
            emit("input", item.id);
        };

        onMounted(() => {
            if (Object.keys(value).length) {
                selected.value = value;
            }
        });

        return {
            data,
            name,
            isOpen,
            isSelected,
            closeDropdown,
            openDropdown,
            select,
            selected,
        };
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
