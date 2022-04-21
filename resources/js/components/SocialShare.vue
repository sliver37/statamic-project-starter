<template>
    <div class="relative">
        <v-dialog>
            <template #trigger>
                <i class="fas cursor-pointer text-primary fa-share-alt"></i>
            </template>
            <h3 class="whitespace-nowrap">Share {{ post.title }} on</h3>
            <ul class="m-0 p-0 text-4xl flex flex-wrap gap-4">
                <li v-for="network in networks" :key="network.name">
                    <share-network
                        class="whitespace-nowrap"
                        :network="network.name"
                        :url="post.permalink"
                        :title="post.title"
                        :description="post.excerpt"
                    >
                        <i :class="[`fab fa-${network.icon}`]"></i>
                    </share-network>
                </li>
            </ul>
        </v-dialog>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    post: Object,
});

const post = props.post;

const networks = [
    { name: "facebook", icon: "facebook-square" },
    { name: "twitter", icon: "twitter-square" },
    { name: "linkedin", icon: "linkedin-in" },
];
</script>

<style></style>
