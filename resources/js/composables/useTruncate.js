import { computed } from 'vue'

export const useTruncate = (text, length = 200, trail = '...', separator = ' ') => {
    return computed(() => {
        const raw = text.replace(/(<([^>]+)>)/gi, "")
        if (raw.length > length) {
            return raw.substr(0, raw.lastIndexOf(separator, length)) + trail
        }
        return raw
    })
}
