<template>
    <div class="card card__project overflow-hidden flex-1">
        <div class="card__content bg-lightgray relative mb-4">
            <a v-if="imageURL" :href="permalink" class="card-image">
                <img
                    loading="lazy"
                    class="w-full object-cover"
                    :alt="title"
                    :src="imageURL"
                />
            </a>
            <a
                class="absolute block w-full px-6 py-3 bg-black bg-opacity-60 card-link bottom-0 no-underline"
                :href="permalink"
            >
                <span class="card-link__text font-bold text-white">
                    {{ location || title }}
                </span>
            </a>
        </div>
        <a
            class="card-link text-primary text-xl no-underline"
            :href="permalink"
        >
            <h4 v-if="title" class="text-2xl text-current mb-0">{{ title }}</h4>
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
        const location = entry?.location || null;
        const ID = entry?.id || "";
        const permalink = entry?.permalink || "";
        const imageURL = computed(() => {
            return entry?.thumbnail
                ? `/img${entry?.thumbnail?.url}?w=1280&h=800`
                : false;
        });

        return {
            title,
            location,
            imageURL,
            ID,
            classes,
            permalink,
        };
    },
};
</script>
