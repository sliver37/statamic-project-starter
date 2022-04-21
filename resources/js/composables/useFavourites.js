import { ref, computed } from 'vue';

const useFavourites = (userId, entryId) => {

    const temp = ref(false);

    const get = () => {
        return temp.value;
    }

    const set = (value) => {
        if (temp.value !== value) {
            temp.value = value;
        }
    };

    const value = computed({
        get() {
            return get();
        },
        set(value) {
            return set(value);
        },
    });

    return {
        get,
        set,
        value
    };
}

export { useFavourites }
