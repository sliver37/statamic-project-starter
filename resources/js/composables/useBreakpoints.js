import { ref, onMounted, onUnmounted } from 'vue';

// Set this to be your projects breakpoints
const SIZES = {
    sm: 640,
    md: 768,
    lg: 1024,
    xl: 1280,
    "2xl": 1536,
}

const useBreakpoints = (size) => {

    let mediaQuery;
    const isAbove = {};
    const matches = ref(false);

    const update = () => {
        if (!window)
            return
        if (!mediaQuery)
            mediaQuery = isAbove[size]
        matches.value = mediaQuery.matches
    }

    onMounted(() => {
        Object.entries(SIZES).forEach(([size, val]) => {
            isAbove[size] = window.matchMedia(`(min-width: ${val}px)`)
        })
        update();

        if (!mediaQuery)
            return

        if ('addEventListener' in mediaQuery)
            mediaQuery.addEventListener('change', update)
        else
            // @ts-expect-error deprecated API
            mediaQuery.addListener(update)

    })

    onUnmounted(() => {
        if ('removeEventListener' in mediaQuery)
            mediaQuery?.removeEventListener('change', update)
        else
            mediaQuery?.removeListener(update)
    })

    return matches
}



export { SIZES, useBreakpoints }
