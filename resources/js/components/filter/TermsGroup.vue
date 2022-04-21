<template>
    <div>
        <h4
            class="no-prefix border-b border-primary flex gap-3 items-center pb-3"
        >
            {{ filter.title }}
        </h4>
        <div class="p-0">
            <component
                :is="`term-${filter.style.value}`"
                :old="old"
                :clear-all="clearAll"
                @clearFilters="clearFilters"
                @input="handleCheck"
                :collection="collection"
                :options="terms.options"
                v-if="terms.options"
            />
        </div>
    </div>
</template>

<script>
import { onMounted, ref, toRefs, reactive } from "vue";

export default {
    props: {
        filter: Object,
        url: Object,
        expanded: {
            type: Boolean,
            default: false,
        },
        collection: String,
        clearAll: Boolean,
    },
    emits: ["filter-change", "clearFilters"],
    setup(props, context) {
        const { filter, expanded, collection, url } = props;
        const { clearAll } = toRefs(props);

        const old = ref([]);

        const taxonomy = ref("");
        const terms = reactive({});

        const handleCheck = (items) => {
            context.emit("filter-change", items);
        };

        const handleGroupSelect = (value) => {
            if (clearAll.value) {
                return "";
            }
        };

        const clearFilters = () => context.emit("clearFilters");

        onMounted(async () => {
            // Set the title of taxonomy
            taxonomy.value = filter.title;

            // Pre-select values if they are in the URL
            const url_values = url[`taxonomies[${[filter.id]}]`];
            if (url_values && url_values.includes(filter.id)) {
                old.value = filter.terms[url_values.split("|")[0]];
            }

            terms.options = filter.terms;
        });

        return {
            taxonomy,
            clearAll,
            collection,
            clearFilters,
            old,
            terms,
            handleCheck,
            expanded,
        };
    },
};
</script>

<style scoped>
.accordion__header {
    padding-left: 0;
    padding-right: 0;
}

.accordion__content {
    padding-left: 0;
    padding-right: 0;
}
</style>
