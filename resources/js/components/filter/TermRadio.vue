<template>
    <div class="checkboxes-group">
        <slot name="before-input" />
        <div
            class="checkbox-group__options rounded overflow-hidden w-full flex flex-col font-bold"
            :class="[columns]"
        >
            <div
                v-if="selected.length"
                @click="clearFilters"
                class="py-2 cursor-pointer text-headings capitalize"
            >
                <i class="fas fa-times text-tertiary"></i> Clear Selection
            </div>

            <v-radio
                v-model="selected"
                @input="handleCheck"
                :options="options"
                :handle="handle"
            />
        </div>
        <slot name="after-input" />
    </div>
</template>

<script>
import { ref, onMounted, computed, toRefs } from "vue";
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
    },
    emits: ["input", "clearFilters"],
    setup(props, context) {
        const { handle, columns, collection } = props;
        const { options, old } = toRefs(props);

        const collectionTitle = computed(() => {
            return collection ? collection.replaceAll("_", " ") : null;
        });

        let selected = ref("");

        const optionsLength = computed(() => {
            return Object.entries(options).length;
        });

        const handleCheck = (e) => {
            console.log(selected.value);
            context.emit("input", selected.value);
        };

        const isParent = (option) => {
            return option.includes("-parent");
        };

        const clearFilters = () => {
            selected.value = "";
            context.emit("clearFilters");
        };

        onMounted(() => {
            if (old?.value?.length || false) {
                selected.value = old.value;
                handleCheck();
            }
        });

        return {
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
