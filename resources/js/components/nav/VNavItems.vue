<template>
    <ul class="nav-items">
        <v-nav-item
            v-for="item in items"
            :item="item"
            :icons="icons"
            :key="item.slug"
        />
    </ul>
</template>

<script>
import slugify from "../../functions/slugify";
export default {
    name: "v-nav-items",
    props: {
        items: Array,
        icons: Object,
    },
    setup(props) {
        const items = slugify(props.items);

        return {
            items,
            icons: props.icons,
        };
    },
};
</script>
