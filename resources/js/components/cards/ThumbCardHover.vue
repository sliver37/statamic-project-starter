<template>
    <div class="card card__case-study relative overflow-hidden">
        <div
            class="card-inner border bg-lightgray overflow-hidden group relative mb-2"
        >
            <a :href="permalink">
                <img
                    loading="lazy"
                    v-if="imageURL"
                    class="w-full mix-blend-multiply card-thumb object-cover"
                    :alt="title"
                    :src="imageURL"
                />
            </a>
            <div
                v-if="content"
                class="card-body leading-relaxed absolute bottom-0 w-full text-white bg-primary bg-opacity-70 group-hover:translate-y-0 transition-transform transform translate-y-full p-2"
            >
                <span v-html="content" />
            </div>
        </div>
        <a class="card-link text-center" :href="permalink">
            <h4 class="card-link__text font-bold" :style="{ color }">
                {{ title }}
            </h4>
        </a>
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
        const content = entry?.content
            ? truncateWords(entry.content, 10, "...")
            : "";
        const ID = entry?.id || "";
        const permalink = entry?.permalink || "";
        const imageURL = computed(() => {
            return entry?.thumbnail
                ? typeof entry.thumbnail === "string"
                    ? `/img/assets/${entry?.thumbnail}?w=600&h=600`
                    : `/img${entry?.thumbnail?.url}?w=600&h=600`
                : false;
        });

        return {
            title,
            content,
            imageURL,
            color,
            ID,
            classes,
            permalink,
        };
    },
};
</script>
