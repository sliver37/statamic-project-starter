<template>
    <div class="card overflow-hidden flex flex-col flex-1" :class="classes">
        <div class="relative border overflow-hidden group flex flex-col flex-1">
            <fav-heart
                entry-id="1"
                user-id="1"
                class="absolute z-10 top-2 right-4"
            />
            <a :href="permalink">
                <img
                    loading="lazy"
                    v-if="imageURL"
                    class="w-full card-thumb object-cover"
                    :alt="title"
                    :src="imageURL"
                />
            </a>
            <div
                class="card-body leading-relaxed absolute bottom-0 z-10 w-full text-white bg-primary bg-opacity-90 group-hover:translate-y-0 transition-transform transform translate-y-full p-6"
            >
                <ul class="m-0 font-light leading-loose">
                    <li v-if="number_of_users">
                        Number of Users: {{ number_of_users }}
                    </li>
                    <li v-if="age_range">Age Range: {{ age_range }}</li>
                    <li v-if="play_type">Play Type: {{ play_type }}</li>
                    <li v-if="inclusion_level">
                        Inclusion Level: {{ inclusion_level }}
                    </li>
                </ul>
            </div>
            <div
                v-if="product_code"
                class="text-white text-sm p-2 bg-black bg-opacity-50 mt-auto"
            >
                <p v-text="product_code" class="text-textmain m-0 relative" />
            </div>
        </div>
        <h4 class="text-primary text-xl py-2 m-0">
            <a
                class="text-textmain no-underline hover:text-textmain relative"
                :href="permalink"
            >
                {{ title }}
            </a>
        </h4>
    </div>
</template>

<script>
import { computed, ref } from "vue";
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
    setup({ entry, actions, titleIcon, classes }) {
        const title = entry?.title ? truncateWords(entry.title, 16, "...") : "";
        const product_code = entry?.product_code || false;
        const ID = entry?.id || "";
        const permalink = entry?.permalink || "";
        const imageURL = computed(() => {
            return entry?.thumbnail
                ? `/img${entry?.thumbnail?.url}?w=300&h=280`
                : false;
        });

        const number_of_users = entry?.number_of_users?.title || false;
        const age_range = entry?.age_range?.title || false;
        const play_type = entry?.play_type?.title || false;
        const inclusion_level = entry?.inclusion_level?.title || false;

        const tempToggle = ref(false);

        const isFavourite = computed({
            get: () => {
                return tempToggle.value;
            },
            set: (value) => {
                return (tempToggle.value = value);
            },
        });

        return {
            title,
            product_code,
            imageURL,
            number_of_users,
            age_range,
            play_type,
            inclusion_level,
            titleIcon,
            isFavourite,
            ID,
            classes,
            permalink,
        };
    },
};
</script>

<style></style>
