<template>
    <div @click="toggleMenu" class="hamburger" :class="{ open: toggled }">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</template>

<script>
import { computed } from "vue";
export default {
    props: {
        toggle: Boolean,
    },
    setup(props) {
        const toggled = computed(() => {
            return props.toggle;
        });

        return {
            toggled,
        };
    },
};
</script>
