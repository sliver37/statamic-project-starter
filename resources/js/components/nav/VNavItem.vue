<template>
    <li
        class="nav-item"
        :class="[
            { 'nav-item--has-children': children.length },
            { 'nav-item--current': isCurrent },
            { 'nav-item--ancestor': slug !== 'home' && isParent },
            [itemClass],
        ]"
    >
        <a @click="handleClick" class="flex items-center" :href="permalink">
            <!-- <v-icon class="mr-2" v-if="iconName" :name="iconName" /> -->
            {{ title }}
            <span
                class="ml-2 nav-arrow"
                v-if="children.length"
                :class="{ 'nav-arrow-opened': subMenuOpen }"
            ></span>
        </a>
        <v-submenu
            v-if="children.length && subMenuOpen"
            :title="title"
            :children="children"
        />
    </li>
</template>

<script>
import { ref, computed, onMounted } from "vue";
export default {
    name: "v-nav-item",
    props: {
        item: Object,
        icons: Object,
    },
    setup(props) {
        const {
            title,
            slug,
            permalink,
            is_current: isCurrent,
            is_parent: isParent,
        } = props.item;
        const children = props.item?.children;
        const iconName = computed(() => props.icons && props.icons[slug]);

        const subMenuOpen = ref(false);
        const toggleSubMenu = () => {
            subMenuOpen.value = !subMenuOpen.value;
        };
        const handleClick = (e) => {
            if (children.length) {
                e.preventDefault();
                return toggleSubMenu();
            }
        };

        return {
            title,
            slug,
            itemClass: props.item.class || "",
            permalink,
            handleClick,
            subMenuOpen,
            children,
            isCurrent,
            isParent,
            iconName,
        };
    },
};
</script>
