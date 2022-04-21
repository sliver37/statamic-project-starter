<template>
    <div class="flex flex-col gap-2 items-center">
        <img
            @click="setColour({ colour_option: colour.slug, external: true })"
            class="object-contain cursor-pointer border w-20 h-20"
            :class="[isActive ? 'border-black' : 'border-primary']"
            :src="colour.icon.url"
        />
        <span
            class="text-sm"
            :class="[isActive ? 'text-black' : 'text-primary']"
            >{{ colour.title }}</span
        >
    </div>
</template>

<script>
import { computed } from "vue";
import { useProductColour } from "../../composables/useProductColour";
export default {
    props: {
        colour: Object,
    },
    setup({ colour }) {
        const { getColour, setColour } = useProductColour();
        const isActive = computed(
            () => getColour.value.colour_option === colour.slug
        );

        return { colour, isActive, setColour };
    },
};
</script>

<style></style>
