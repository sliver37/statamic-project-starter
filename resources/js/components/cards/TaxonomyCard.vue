<template>
    <div class="card card__case-study relative overflow-hidden flex-1">
        <div class="bg-lightgray mb-6">
            <a class="flex" :href="permalink">
                <img
                    v-if="thumbnailURL"
                    class="w-1/2 bg-lightgray mix-blend-multiply card-thumb object-cover"
                    :alt="title"
                    :src="thumbnailURL"
                />
                <img
                    v-if="productShotURL"
                    class="w-1/2 card-thumb object-cover mix-blend-multiply"
                    :alt="title"
                    :src="productShotURL"
                />
            </a>
        </div>
        <a :href="permalink">
            <h4
                class="card-link__text font-bold text-primary"
                :style="{ color }"
            >
                {{ title }}
            </h4>
        </a>
        <div v-if="content" class="card-body pb-6">
            <span v-html="content" />
        </div>
        <a class="btn" :href="permalink"> View Products</a>
    </div>
</template>

<script>
import { computed } from "vue";
import { truncateWords } from "../../functions/helpers";
export default {
    props: {
        entry: Object,
        color: String,
        classes: {
            type: String,
            default: "bg-white",
        },
    },
    setup({ entry, classes, color }) {
        const title = entry?.title ? truncateWords(entry.title, 16, "...") : "";
        const content = entry?.content ? entry.content : "";
        const ID = entry?.id || "";
        const permalink = entry?.permalink || "";
        const thumbnailURL = computed(() => {
            return entry?.thumbnail
                ? typeof entry.thumbnail === "string"
                    ? `/img/assets/${entry?.thumbnail}?w=500&h=500`
                    : `/img${entry?.thumbnail?.url}?w=500&h=500`
                : false;
        });
        const productShotURL = computed(() => {
            return entry?.product_shot
                ? typeof entry.product_shot === "string"
                    ? `/img/assets/${entry?.product_shot}?w=500&h=500`
                    : `/img${entry?.product_shot?.url}?w=500&h=500`
                : false;
        });

        return {
            title,
            content,
            thumbnailURL,
            productShotURL,
            color,
            ID,
            classes,
            permalink,
        };
    },
};
</script>
