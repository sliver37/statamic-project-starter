<template>
    <div
        class="youtube-iframe-wrapper relative flex items-center justify-center"
    >
        <img
            class="absolute brightness-75 opacity-1 transition-opacity"
            :class="[isPlaying && 'opacity-0 pointer-events-none']"
            :src="`https://img.youtube.com/vi/${youtubeID}/maxresdefault.jpg`"
            alt="Video title"
        />
        <youtube
            :video-id="youtubeID"
            @ready="onReady"
            @playerStateChange="stateChange"
        />
    </div>
</template>

<script>
import { ref, computed, toRefs } from "vue";
import getIdFromUrl from "get-youtube-id";

export default {
    name: "YoutubePlayer",
    props: {
        videoId: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        const player = ref(null);
        const playState = ref(null);
        const { videoId } = toRefs(props);
        const youtubeID = computed(() => {
            return videoId.value.includes("http")
                ? getIdFromUrl(videoId.value)
                : videoId.value;
        });

        const stateChange = (event) => {
            playState.value = event;
        };

        const isPlaying = computed(() => {
            return playState.value === "playing";
        });

        const isBuffering = computed(() => {
            return playState.value === "buffering";
        });

        const onReady = (e) => {
            player.value = e;
        };

        const playVideo = () => {
            if (player.value) {
                player.value.playVideo();
            }
        };

        return {
            onReady,
            player,
            isPlaying,
            isBuffering,
            stateChange,
            youtubeID,
            playVideo,
        };
    },
};
</script>

<style></style>
