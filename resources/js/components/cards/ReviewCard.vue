<template>
    <div class="card card__reviews rounded relative overflow-hidden flex-1">
        <div class="card-body p-6 pb-24 lg:p-8 lg:pb-24">
            <div class="star-rating mb-6">
                <v-rating
                    v-if="star_rating"
                    :max="5"
                    :current="star_rating"
                ></v-rating>
            </div>
            <h4 class="text-lg font-bold mb-4">{{ main_quote }}</h4>
            <div class="text-sm">
                <div v-html="excerpt" />
                <span class="name block mt-4">&mdash; {{ title }}</span>
            </div>
        </div>
        <a
            class="absolute glightbox no-underline bottom-6 left-6 lg:bottom-8 lg:left-8"
            :href="`#${ID}`"
        >
            <span class="card-link__text font-semibold text-primary"
                >Read More</span
            >
            <g-lightbox :id="ID">
                <div class="card-body p-6 pb-24 lg:p-8 lg:pb-24">
                    <div class="star-rating mb-8">
                        <v-rating
                            v-if="star_rating"
                            :max="5"
                            :current="star_rating"
                        ></v-rating>
                    </div>
                    <h4 class="text-lg font-bold mb-4">{{ main_quote }}</h4>
                    <div class="text-sm">
                        <div v-html="content" />
                        <span class="name block mt-4">&mdash; {{ title }}</span>
                    </div>
                </div>
            </g-lightbox>
        </a>
    </div>
</template>

<script>
import { useTruncate } from "../../composables/useTruncate";
import { truncateWords } from "../../functions/helpers";
export default {
    props: {
        entry: Object,
        classes: {
            type: String,
            default: "bg-white",
        },
        actions: Array,
        titleIcon: {
            type: String,
            default: "chevron-right",
        },
    },
    setup({ entry }) {
        const title = entry?.title ? truncateWords(entry.title, 16, "...") : "";
        const ID = entry?.id || "";
        const permalink = entry?.permalink || "";
        const star_rating = entry?.star_rating || "";
        const main_quote = entry?.main_quote || "";
        const content = entry?.content;
        const excerpt = useTruncate(entry?.content || "");

        return {
            title,
            star_rating,
            main_quote,
            ID,
            content,
            excerpt,
            permalink,
        };
    },
};
</script>

<style></style>
