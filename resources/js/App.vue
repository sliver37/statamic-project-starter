<template>
    <slot></slot>
</template>

<script>
import { onMounted } from "vue";
export default {
    setup() {
        const title = "App Bois";
        onMounted(() => {});
        return {
            title,
        };
    },
};
</script>

<style></style>
