<template>
    <ul
        ref="subMenu"
        class="nav-items sub-menu"
        :class="[{}, { 'sub-menu--overflow': subMenuEdge }]"
    >
        <v-nav-item v-for="item in children" :item="item" :key="item.slug" />
    </ul>
</template>

<script>
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
import { debounce } from "../../functions/helpers";
export default {
    name: "v-submenu",
    props: {
        title: String,
        children: {
            type: Array,
            required: true,
        },
    },
    setup(props) {
        const children = props.children;
        const subMenu = ref(null);
        const subMenuEdge = ref(false);

        // Need to throttle this
        const windowWidth = ref(window.innerWidth);

        watch(windowWidth, () => {
            edgeDetect();
        });

        const edgeDetect = () => {
            const el = subMenu.value;
            if (!el) {
                return;
            }
            const bb = el.getBoundingClientRect();
            const offsetLeft = bb.left;
            const width = bb.width;
            const isEntirelyVisible = offsetLeft + width <= windowWidth.value;

            if (!isEntirelyVisible) {
                subMenuEdge.value = true;
            } else {
                subMenuEdge.value = false;
            }
        };

        const onResize = () => {
            windowWidth.value = window.innerWidth;
        };

        onMounted(() => {
            edgeDetect();
            window.addEventListener(
                "resize",
                debounce(onResize, 500, false, true)
            );
        });

        onBeforeUnmount(() => {
            window.removeEventListener(
                "resize",
                debounce(onResize, 500, false, true)
            );
        });

        return {
            subMenu,
            subMenuEdge,
            children,
        };
    },
};
</script>
