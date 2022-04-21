<template>
    <div
        class="card card__case-study rounded flex flex-col gap-3 relative overflow-hidden flex-1"
    >
        <div v-if="imageURL" class="card-image rounded">
            <a :href="permalink"
                ><img
                    loading="lazy"
                    class="w-full object-cover"
                    :alt="title"
                    :src="imageURL"
            /></a>
        </div>
        <span class="font-bold">{{ category }}</span>
        <h4 class="text-xl m-0 p-0">
            <a :href="permalink">{{ title }}</a>
        </h4>
        <span class="block mb-2" v-html="content" />
        <div class="flex items-center gap-4">
            <a class="btn card-link" :href="permalink"> Learn More </a>
            <social-share :post="entry" />
        </div>
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
        const category = entry?.category ? entry?.category[0].title : "";
        console.log(entry);
        const content = entry?.excerpt
            ? entry.excerpt
            : entry?.content &&
              truncateWords(entry.content, 16, "...").replace(
                  /(<([^>]+)>)/gi,
                  ""
              );
        const ID = entry?.id || "";
        const permalink = entry?.permalink || "";
        const imageURL = computed(() => {
            return entry?.thumbnail
                ? `/img${entry?.thumbnail?.url}?w=1160&h=624`
                : false;
        });

        return {
            entry,
            title,
            category,
            content,
            imageURL,
            ID,
            classes,
            permalink,
        };
    },
};
</script>
