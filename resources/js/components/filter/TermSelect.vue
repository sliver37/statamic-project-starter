<template>
    <styled-select
        @input="handleCheck"
        :value="old"
        :data="Object.values(options)"
    ></styled-select>
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
            type: [Array, Object],
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
    setup(props, { emit }) {
        const { handle, columns, collection } = props;
        const { options, old } = toRefs(props);

        console.log({ options });

        const collectionTitle = computed(() => {
            return collection ? collection.replaceAll("_", " ") : null;
        });

        let selected = ref("");

        const optionsLength = computed(() => {
            return Object.entries(options).length;
        });

        const handleCheck = ($event) => {
            selected.value = $event;
            emit("input", $event);
        };

        onMounted(() => {
            if (old?.value?.length || false) {
                selected.value = old.id;
                handleCheck();
            }
        });

        return {
            collectionTitle,
            selected,
            old,
            columns,
            handle,
            handleCheck,
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
