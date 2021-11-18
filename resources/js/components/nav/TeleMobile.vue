<template>
  <teleport :disabled="!teleportMobileMenu" to="#mobile-nav">
    <div :style="`order:${teleportMobileMenu ? order : 'unset'};`">
      <slot />
    </div>
  </teleport>
</template>

<script>
import { computed, ref, onMounted } from "vue";
import { isAbove } from "../../functions/breakpoints";
export default {
  props: {
    order: {
      type: Number,
      default: 0,
    },
  },
  setup({ order }) {
    const isLargeBreakpoint = ref(true);

    const teleportMobileMenu = computed(() => {
      return !isLargeBreakpoint.value;
    });

    onMounted(() => {
      // Immediate check
      isLargeBreakpoint.value = isAbove.lg.matches;

      // On change
      isAbove.lg.addEventListener("change", (e) => {
        if (e.matches) {
          isLargeBreakpoint.value = true;
        } else {
          isLargeBreakpoint.value = false;
        }
      });
    });

    return {
      order,
      teleportMobileMenu,
    };
  },
};
</script>

<style></style>
