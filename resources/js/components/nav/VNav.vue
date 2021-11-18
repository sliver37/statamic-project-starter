<template>
  <div
    class="nav-wrapper"
    :class="[
      `nav-wrapper__${handle}`,
      { 'nav-wrapper--nav-open': mobileMenuOpen },
      { 'nav-wrapper--has-toggle': hasToggle },
      { 'nav-wrapper--always-mobile': always_mobile },
    ]"
  >
    <v-hamburger
      @click.stop="toggleMobileMenu"
      :toggle="mobileMenuOpen"
      v-if="hasToggle"
    />

    <teleport :disabled="!teleportMobileMenu" to="#mobile-nav">
      <v-hamburger
        @click.stop="toggleMobileMenu"
        :toggle="mobileMenuOpen"
        v-if="hasToggle"
        class="text-white w-10 h-10 absolute top-10 right-8"
      />
      <nav
        class="nav"
        :class="[`nav__${handle}`]"
        v-show="!hasToggle || isVisible"
      >
        <v-nav-items :items="items" :icons="icons" />
      </nav>
    </teleport>
  </div>
</template>

<script>
import { onMounted, ref, computed } from "vue";
import { isAbove } from "../../functions/breakpoints";
export default {
  name: "v-nav",
  props: {
    items: Array,
    icons: Object,
    handle: String,
    has_toggle: Boolean,
    to_mobile_menu: Boolean,
    always_mobile: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    const { items, handle, to_mobile_menu, has_toggle, always_mobile } = props;
    const isLargeBreakpoint = ref(true);
    const mobileMenuOpen = ref(false);

    const isVisible = computed(() => {
      if (!has_toggle) {
        return true;
      }

      if (!always_mobile && isLargeBreakpoint.value) {
        return true;
      }

      return mobileMenuOpen.value;
    });

    const teleportMobileMenu = computed(() => {
      return to_mobile_menu && (always_mobile || !isLargeBreakpoint.value);
    });

    const toggleMobileMenu = () => {
      mobileMenuOpen.value = !mobileMenuOpen.value;

      if (to_mobile_menu && mobileMenuOpen.value) {
        document.body.classList.add("--mobile-menu-open");
        listeners(document.body, "click", "add", checkOutsideClick);
      } else {
        document.body.classList.remove("--mobile-menu-open");
        listeners(document.body, "click", "remove", checkOutsideClick);
      }
    };

    const checkOutsideClick = (e) => {
      if (!e.target.closest("#mobile-nav")) {
        toggleMobileMenu();
      }
    };

    const listeners = (el, handler, action, cb) => {
      el[`${action}EventListener`](handler, cb);
    };

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

        if (mobileMenuOpen.value) {
          toggleMobileMenu();
        }
      });
    });

    return {
      items,
      handle,
      isVisible,
      isLargeBreakpoint,
      toggleMobileMenu,
      mobileMenuOpen,
      always_mobile,
      hasToggle: has_toggle,
      teleportMobileMenu,
    };
  },
};
</script>
