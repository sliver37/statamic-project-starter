import { ref, reactive, computed, watch, onMounted, nextTick } from 'vue'
import { useUrlSearchParams } from '@vueuse/core'

let url = useUrlSearchParams('history');

const results = reactive({
    data: ref([]),
    meta: {}
});

const searchQuery = ref(url.q);

const activeFilterCount = computed(() => Object.keys(url).reduce((a, b) => {
    if (String(url[b]).includes('|')) {
        return a + b.split('|').length
    }
    return b !== 'page' ? a + 1 : a
}, 0));

const useFilter = (api, options = {}) => {
    options = {
        collection: 'activities',
        param: 'taxonomies',
        condition: false,
        baseFilters: {},
        ...options
    }

    onMounted(() => {
        if (Object.keys(options.baseFilters).length !== 0) {
            Object.keys(options.baseFilters).forEach(key => {
                console.log(options.baseFilters[key])
                url[key] = options.baseFilters[key].join("|");
            })
        }
    })

    const clearFilters = () => {
        Object.keys(url).forEach(key => {
            if (!options?.baseFilters) return delete url[key]

            if (options?.baseFilters[key]) {
                url[key] = options.baseFilters[key]
            } else {
                delete url[key]
            }
        })

        searchQuery.value = '';
    };

    const handleSearch = (search) => {
        if (search) {
            url.q = search;
        } else {
            delete url.q;
        }
        searchQuery.value = search;
    }

    const handleFilter = ({
        term = "",
        filter = null,
    } = {}) => {
        delete url.page

        filter.length
            ? url[`${options.param}[${term}${!!options.condition ? `:${options.condition}` : ''}]`] = Array.isArray(filter) ? filter.join("|") : filter
            : delete url[`${options.param}[${term}${!!options.condition ? `:${options.condition}` : ''}]`];
    };

    // Anytime our fitler URL changes, we will do a fetch
    watch(url, (val) => {
        nextTick(() => {
            fetchResults();
        })
    });

    const fetchResults = async () => {
        try {
            let res = await api.get(
                `/collections/${options.collection}/entries${decodeURIComponent(
                    location.search
                )}`
            );
            if (res) {
                results.data = res.data;
                results.meta = res.meta
            }
        } catch (error) {
            console.log(error)
        }
    };

    return {
        fetchResults,
        results,
        url,
        handleFilter,
        handleSearch,
        searchQuery,
        clearFilters,
        activeFilterCount
    }
}

export { useFilter, searchQuery, results, url }
