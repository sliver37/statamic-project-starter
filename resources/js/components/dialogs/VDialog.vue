<template>
    <div @click="handleClick">
        <slot name="trigger"></slot>
    </div>
    <dialog class="relative py-8 pl-8 pr-16" v-bind="$attrs" ref="dialog">
        <i
            @click="handleClick"
            class="fas p-3 bg-black bg-opacity-60 top-0 right-0 text-white absolute cursor-pointer fa-times"
        ></i>
        <slot />
    </dialog>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
const dialog = ref(null);
const isOpen = ref(false);

watch(isOpen, (value) => {
    if (value) {
        dialog.value.showModal();
    } else {
        dialog.value.close();
    }
});

const closeOnOutsideClick = (e) => {
    if (
        e.offsetX < 0 ||
        e.offsetX > e.target.offsetWidth ||
        e.offsetY < 0 ||
        e.offsetY > e.target.offsetHeight
    ) {
        isOpen.value = false;
    }
};

onMounted(() => {
    dialog.value.addEventListener("click", closeOnOutsideClick, false);
});

onBeforeUnmount(() => {
    dialog.value.removeEventListener("click", closeOnOutsideClick, false);
});

const handleClick = () => {
    isOpen.value = !isOpen.value;
};
</script>

<style></style>
