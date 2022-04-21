import { defineComponent, h, ref, toRefs, reactive, watch, onBeforeUnmount, onMounted } from 'vue';
import getIdFromUrl from 'get-youtube-id';
const YTPlayer = require('youtube-player')

const UNSTARTED = -1
const ENDED = 0
const PLAYING = 1
const PAUSED = 2
const BUFFERING = 3
const CUED = 5

export default defineComponent({
    name: 'Youtube',
    props: {
        videoId: String,
        playerVars: {
            type: Object,
            default: () => ({})
        },
        width: {
            type: [Number, String],
            default: '100%'
        },
        height: {
            type: [Number, String],
            default: '100%'
        },
        nocookie: {
            type: Boolean,
            default: false
        }
    },
    setup(props, { emit }) {
        let player = reactive({});
        let youtubeID = "";
        const { playerVars, nocookie } = props;
        const { width, height, videoId } = toRefs(props);
        const playerEL = ref(null);
        const events = {
            [UNSTARTED]: 'unstarted',
            [PLAYING]: 'playing',
            [PAUSED]: 'paused',
            [ENDED]: 'ended',
            [BUFFERING]: 'buffering',
            [CUED]: 'cued'
        };

        const playerReady = (e) => {
            emit('ready', e.target)
        }
        const playerStateChange = (e) => {
            if (e.data !== null && e.data !== UNSTARTED) {
                // emit(events[e.data], e.target)
                emit("playerStateChange", events[e.data])
            }
        }
        const playerError = (e) => {
            emit('error', e.target)
        }
        const updatePlayer = (videoId) => {
            youtubeID = videoId.value.includes('http') ? getIdFromUrl(videoId.value) : videoId.value;

            if (!youtubeID) {
                player.stopVideo()
                return
            }

            const params = { videoId: youtubeID }

            if (typeof playerVars.start === 'number') {
                params.startSeconds = playerVars.start
            }

            if (typeof playerVars.end === 'number') {
                params.endSeconds = playerVars.end
            }

            if (playerVars.autoplay === 1) {
                player.loadVideoById(params)
                return
            }

            player.cueVideoById(params)
        }

        watch(videoId, updatePlayer)

        onMounted(() => {
            window.YTConfig = {
                host: 'https://www.youtube.com/iframe_api'
            }

            const host = nocookie ? 'https://www.youtube-nocookie.com' : 'https://www.youtube.com'

            youtubeID = videoId.value.includes('http') ? getIdFromUrl(videoId.value) : videoId.value;

            player = YTPlayer(playerEL.value, {
                host,
                width: width.value,
                height: height.value,
                videoId: youtubeID,
                playerVars: playerVars
            })

            player.on('ready', playerReady)
            player.on('stateChange', playerStateChange)
            player.on('error', playerError)
        })

        onBeforeUnmount(() => {
            if (player !== null && player.destroy) {
                player.destroy()
            }
        })

        return () => {
            return h('div', {
                class: 'aspect-video w-full h-full',
                ref: playerEL
            })
        }
    }
})
