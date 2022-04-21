<script setup>
import { onMounted } from "vue";
import { useFilter, url } from "../../composables/useFilter";
import { contentAPI } from "../../services/contentAPI";

const props = defineProps({
    filters: Object,
    collection: String,
    headerIcons: {
        type: Boolean,
        default: true,
    },
    filterGroupClass: {
        type: String,
        default: "",
    },
    baseFilters: {
        type: Object,
        default: () => ({}),
    },
});

const { collection, baseFilters } = props;

const { handleFilter, fetchResults, clearFilters } = useFilter(contentAPI, {
    collection,
    param: "taxonomies",
    condition: false,
    baseFilters,
});

onMounted(() => {
    fetchResults();
});
</script>

<style></style>

<template>
    <div>
        <component
            v-for="(filter, index) in filters"
            :key="filter.id"
            :is="`terms-group`"
            :url="url"
            :headerIcons="headerIcons"
            :class="[filterGroupClass]"
            @clearFilters="clearFilters()"
            @filter-change="
                handleFilter({
                    term: filter.id,
                    filter: $event,
                })
            "
            :collection="props.collection"
            :filter="filter"
            :expanded="index === 0 || null"
        />
    </div>
</template>
