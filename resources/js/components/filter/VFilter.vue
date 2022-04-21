<template>
    <div class="buildamic-row gap-10 w-full">
        <div class="buildamic-column col col-9">
            <template v-if="showResults && results">
                <v-filter-results
                    class="mb-12"
                    :card="card"
                    :columns="columns"
                />
                <v-pagination
                    v-if="pagination"
                    :pagination="pagination"
                    @page-changed="pageChange"
                />
            </template>
        </div>
        <div class="col buildamic-column col-3 w-full">
            <div v-if="filters.length" data-istoggle>
                <v-filter-controls
                    class="flex flex-col gap-10"
                    :base-filters="baseFilters"
                    :exclude="exclude"
                    :filters="filters"
                    :collection="collection"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { toRefs, computed } from "vue";
import { results, url } from "../../composables/useFilter";

export default {
    props: {
        filters: Object,
        filterTitle: String,
        card: String,
        columns: String,
        collection: String,
        exclude: Array,
        showResults: {
            type: Boolean,
            default: true,
        },
        baseFilters: {
            type: Object,
            default: {},
        },
    },
    setup(props) {
        const {
            collection,
            card,
            filterTitle,
            columns,
            baseFilters,
            showResults,
            exclude,
        } = props;
        const { filters } = toRefs(props);

        const pagination = computed(() => {
            return results.meta;
        });

        const pageChange = (page) => {
            if (url.page === page) {
                return;
            }
            if (page === 1) {
                if (url.page) {
                    delete url.page;
                }
            } else {
                url.page = page;
            }
        };

        return {
            filterTitle,
            filters,
            collection,
            columns,
            card,
            pagination,
            pageChange,
            results,
            exclude,
            showResults,
            baseFilters,
        };
    },
};
</script>

<style></style>
