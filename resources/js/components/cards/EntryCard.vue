<template>
    <div
        class="card card__case-study relative overflow-hidden flex flex-col flex-1"
    >
        <div v-if="imageURL" class="card-image mb-4">
            <img
                loading="lazy"
                class="w-full object-cover"
                :alt="imageALT"
                :src="imageURL"
            />
        </div>
        <div class="card-body flex-grow mb-4">
            <h4 class="text-xl text-primary">{{ title }}</h4>
            <span v-html="content" />
        </div>
        <a class="card-link no-underline" :href="permalink">
            <span class="card-link__text font-bold text-primary"
                >Learn More</span
            >
        </a>
    </div>
</template>

<script>
import { computed } from "vue";
import { truncateWords } from "../../functions/helpers";
export default {
    props: {
        entry: Object,
        classes: {
            type: String,
            default: "bg-white",
        },
    },
    setup({ entry, classes }) {
        const title = entry?.title ? truncateWords(entry.title, 16, "...") : "";
        const content = entry?.excerpt
            ? entry.excerpt
            : entry?.content
            ? entry.content
            : "";
        const ID = entry?.id || "";
        const permalink = entry?.permalink || "";
        const imageURL = computed(() => {
            return entry?.thumbnail
                ? `/img${entry?.thumbnail?.url}?w=1160&h=624`
                : false;
        });

        const imageALT = computed(() => {
            return entry?.thumbnail ? entry?.thumbnail?.alt : false;
        });

        return {
            title,
            content,
            imageURL,
            imageALT,
            ID,
            classes,
            permalink,
        };
    },
};
</script>
