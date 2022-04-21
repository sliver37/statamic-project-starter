import { ref, computed } from 'vue';
const currentColour = ref('');

const useProductColour = () => {

    const setColour = (colour) => {
        currentColour.value = colour
    };

    const getColour = computed(() => {
        return currentColour.value;
    })

    return {
        setColour,
        getColour,
    }
}

export { useProductColour }
