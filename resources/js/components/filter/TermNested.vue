<template>
    <div class="checkboxes-group">
        <slot name="before-input" />
        <ul
            class="checkbox-group__options mb-0 rounded overflow-hidden w-full flex flex-col font-bold"
            :class="[columns]"
        >
            <accordion
                class="gap-4"
                :state_classes="{
                    inactive: {
                        header: 'bg-transparent',
                    },
                }"
                :icon="{
                    active: 'caret-down',
                    inactive: 'caret-up',
                    class: 'order-2 ml-auto',
                }"
            >
                <template v-for="option in options" :key="option.id">
                    <accordion-panel>
                        <accordion-panel-header
                            data-font="text-xl font-normal text-primary mb-0"
                            class="py-0 cursor-pointer"
                        >
                            {{ option.title }}
                        </accordion-panel-header>
                        <accordion-panel-content
                            class="px-4"
                            v-if="option.terms"
                        >
                            <template
                                v-for="child in option.terms"
                                :key="child.id"
                            >
                                <v-checkbox
                                    v-model="selected"
                                    @change="handleCheck"
                                    :option="child"
                                    :handle="handle"
                                />
                            </template>
                        </accordion-panel-content>
                    </accordion-panel>
                </template>
            </accordion>
        </ul>
        <slot name="after-input" />
    </div>
</template>

<script>
import { ref, onMounted, computed, watch, toRefs } from "vue";
export default {
    props: {
        options: {
            type: [Object],
            required: false,
        },
        old: {
            type: [Array],
        },
        handle: {
            type: String,
            required: false,
            default: "",
        },
        collection: String,
        columns: {
            type: String,
            required: false,
            default: "",
        },
        groupSelect: {
            type: String,
            required: false,
        },
        clearAll: Boolean,
    },
    emits: [
        "input",
        "select-all",
        "select-some",
        "select-none",
        "clearFilters",
    ],
    setup(props, context) {
        const { handle, columns, collection } = props;
        const { groupSelect, options, old, clearAll } = toRefs(props);
        const is_nested =
            options.value.is_nested && delete options.value.is_nested;

        const collectionTitle = computed(() => {
            return collection ? collection.replaceAll("_", " ") : null;
        });

        let selected = ref([]);

        const optionsLength = computed(() => {
            return Object.entries(options).length;
        });

        const handleCheck = (e) => {
            context.emit("input", selected.value);

            if (selected.value.length === Object.entries(options)) {
                return context.emit("select-all");
            } else if (selected.value.length) {
                return context.emit("select-some");
            }

            return context.emit("select-none");
        };

        const isParent = (option) => {
            return option.includes("-parent");
        };

        const clearFilters = () => context.emit("clearFilters");

        const selectAll = () => {
            if (typeof options === "object") {
                return (selected.value = Object.keys(options.value).filter(
                    (el) => !el.includes("-parent")
                ));
            }
            selected.value = options.map((option) => option[0]);
        };

        const unSelectAll = () => {
            return (selected.value = []);
        };

        const handleGroupSelect = () => {
            if (groupSelect.value === "all") {
                selectAll();
            } else if (groupSelect.value === "none") {
                unSelectAll();
            } else {
                return;
            }

            handleCheck();
        };

        watch(groupSelect, () => {
            handleGroupSelect();
        });

        watch(clearAll, () => {
            if (clearAll.value && selected.value.length) {
                unSelectAll();
                handleCheck();
            }
        });

        onMounted(() => {
            if (old?.value?.length || false) {
                selected.value = old.value;
                handleCheck();
            }
        });

        return {
            unSelectAll,
            collectionTitle,
            clearFilters,
            selected,
            columns,
            handle,
            handleCheck,
            isParent,
            optionsLength,
        };
    },
};
</script>

<style>
.custom-label input:checked + svg {
    display: block !important;
}
</style>
