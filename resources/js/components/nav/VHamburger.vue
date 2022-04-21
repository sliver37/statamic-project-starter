<template>
    <div>
        <div
            @click.stop="toggleMobileMenu"
            class="hamburger"
            :class="{ open: toggled }"
        >
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <slot v-if="toggled" />
    </div>
</template>

<script>
import { computed, onMounted, ref } from "vue";
export default {
    props: {
        toggle: Boolean,
    },
    setup(props, { slots }) {
        const toggled = ref(props.toggle);

        const element = ref(null);

        onMounted(() => {
            element.value = slots.default && slots.default()[0];
        });

        const listeners = (el, handler, action, cb) => {
            el[`${action}EventListener`](handler, cb);
        };

        const checkOutsideClick = (e) => {
            if (!e.target.closest("#mobile-nav")) {
                toggleMobileMenu();
            }
        };

        const toggleMobileMenu = () => {
            if (element.value) {
                return (toggled.value = !toggled.value);
            }

            if (!document.body.classList.contains("--mobile-menu-open")) {
                document.body.classList.add("--mobile-menu-open");
                listeners(document.body, "click", "add", checkOutsideClick);
            } else {
                document.body.classList.remove("--mobile-menu-open");
                listeners(document.body, "click", "remove", checkOutsideClick);
            }
        };

        return {
            toggled,
            toggleMobileMenu,
        };
    },
};
</script>
