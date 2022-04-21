<template>
    <div
        ref="resultsContainer"
        v-if="results.data.length"
        class="filter-results grid gap-6 w-full"
        :class="[props.columns ? props.columns : 'md:grid-cols-3']"
    >
        <component
            :is="props.card"
            v-for="result in results.data"
            :key="result.id"
            :entry="result"
            :actions="['toggle']"
        />
    </div>
    <p v-else>
        Sorry there were no results, try a different combination of filters
    </p>
</template>

<script setup>
import { results } from "../../composables/useFilter";

const props = defineProps({
    columns: String,
    card: String,
});
</script>

<style></style>
