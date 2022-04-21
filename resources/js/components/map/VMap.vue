<template>
    <GMapMap
        :center="center"
        :zoom="7"
        :options="options"
        class="max-h-screen h-[60vh] w-full relative"
    >
        <GMapCluster :styles="clusterStyles">
            <GMapMarker
                icon="/assets/icons/map/marker.svg"
                :key="index"
                v-for="(m, index) in markers"
                :position="m.position"
                :clickable="true"
                :draggable="false"
                @click="handleMarkerClick(m)"
            >
                <GMapInfoWindow
                    @closeclick="openInfoWindow(null)"
                    :opened="openedMarkerID === m.id"
                >
                    <div class="flex flex-col gap-3 p-2">
                        <h3 class="m-0">
                            <a :href="m.permalink">{{ m.title }}</a>
                        </h3>
                        <div v-html="m.excerpt" />
                    </div>
                </GMapInfoWindow>
            </GMapMarker>
        </GMapCluster>
        <v-filter-controls
            class="flex flex-col lg:flex-row p-6 lg:absolute lg:w-[70vw] shadow-lg bottom-10 left-0 right-0 mx-auto bg-white items-center justify-center gap-4 map-filter-controls"
            filter-group-class="lg:flex w-full lg:w-auto items-center gap-3"
            :header-icons="false"
            :filters="filters"
            collection="projects"
        ></v-filter-controls>
    </GMapMap>
</template>

<script>
import { watch, ref, reactive } from "vue";
import { results } from "../../composables/useFilter";
import { truncateWords } from "../../functions/helpers";
export default {
    name: "Map",
    props: {
        filters: {
            type: Object,
        },
    },
    setup({ filters }) {
        const options = {
            mapId: "b70a49b5957c1fea",
        };

        let markers = ref([]);

        const openedMarkerID = ref(null);

        const clusterIcon = (color) =>
            window.btoa(`
            <svg fill="${color}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240">
                <circle cx="120" cy="120" opacity="1" r="94" fill="white" />
                <circle cx="120" cy="120" opacity="1" r="90" />
                <circle cx="120" cy="120" opacity=".2" r="120" />
            </svg>`);

        const clusterStyles = [`#D3232A`, `#D3232A`, `#D3232A`, `#D3232A`].map(
            (color, i) => ({
                url: `data:image/svg+xml;base64,${clusterIcon(color)}`,
                height: (i + 1) * 38,
                width: (i + 1) * 38,
                textColor: `white`,
                textSize: ((i + 1) * 38) / 2.5,
            })
        );

        watch(results, (res) => {
            markers.value = res.data.reduce((markers, cur) => {
                if (cur?.latitude && cur?.longitude) {
                    markers.push({
                        id: cur.id,
                        title: cur.title,
                        permalink: cur.permalink,
                        excerpt:
                            cur.excerpt ??
                            truncateWords(cur.content, 40, "..."),
                        position: {
                            lat: cur.latitude,
                            lng: cur.longitude,
                        },
                    });
                }
                return markers;
            }, []);
        });

        const center = ref({ lat: -35, lng: 150 });

        const openInfoWindow = (ID) => {
            openedMarkerID.value = ID;
        };

        const handleMarkerClick = (marker) => {
            openInfoWindow(marker.id);
            center.value = { ...marker.position };
        };

        return {
            options,
            markers,
            openedMarkerID,
            openInfoWindow,
            center,
            clusterStyles,
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
