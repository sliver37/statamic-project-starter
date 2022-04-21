<template>
    <v-loading-spinner class="h-20 w-20" v-if="loading" />
    <GMapMap
        v-show="!loading"
        :center="center"
        :zoom="7"
        @idle="mapLoaded"
        :options="options"
        class="max-h-screen h-[60vh] w-full relative"
    >
        <GMapMarker
            icon="/assets/icons/map/marker.svg"
            :key="index"
            v-for="(m, index) in markers"
            :position="m.position"
            :clickable="true"
            :draggable="false"
            @click="handleMarkerClick(m)"
        >
            <!-- <GMapInfoWindow
                    @closeclick="openInfoWindow(null)"
                    :opened="openedMarkerID === m.id"
                >
                    <div class="flex flex-col gap-3 p-2">
                        <h3 class="m-0">
                            <a :href="m.permalink">{{ m.title }}</a>
                        </h3>
                        <div v-html="m.excerpt" />
                    </div>
                </GMapInfoWindow> -->
        </GMapMarker>
    </GMapMap>
</template>

<script>
import { ref, onMounted } from "vue";
export default {
    name: "Map",
    props: {
        location: {
            type: Object,
        },
    },
    setup({ location }) {
        const options = {
            mapId: "b70a49b5957c1fea",
        };

        const loading = ref(true);

        let markers = ref([]);
        const openedMarkerID = ref(null);
        const center = ref({ lat: -35, lng: 150 });

        onMounted(() => {
            markers.value.push({ position: location });
            center.value = location;
            console.log({ markers });
        });

        const openInfoWindow = (ID) => {
            openedMarkerID.value = ID;
        };

        const handleMarkerClick = (marker) => {
            // openInfoWindow(marker.id);
            center.value = { ...marker.position };
        };

        const mapLoaded = () => {
            loading.value = false;
        };

        return {
            options,
            markers,
            mapLoaded,
            loading,
            openedMarkerID,
            center,
            handleMarkerClick,
        };
    },
};
</script>

<style lang="scss">
#app {
    .vue-map-container {
        display: flex;
        flex-direction: column;
        .vue-map {
            flex-grow: 1;
        }
    }
    .map-filter-controls {
        h4 {
            @apply pb-0 mb-0 border-0;
        }
    }
    .cluster > div {
        font-family: var(--font-headings);
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0;
        bottom: 0;
    }
}
</style>
