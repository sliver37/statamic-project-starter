<template>
    <label class="custom-label flex gap-2 items-center py-2" tabindex="0">
        <div
            class="checkbox-bg w-6 h-6 p-1 flex justify-center items-center mr-2 flex-shrink-0 border border-primary"
        >
            <input
                type="checkbox"
                :name="handle"
                v-model="selected"
                :value="option.id"
                class="hidden"
            />
            <svg
                class="hidden text-secondary pointer-events-none w-full"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 52 52"
                stroke-miterlimit="10"
                stroke-width="8"
                stroke="red"
                fill="none"
            >
                <path d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>
        </div>
        <span
            class="select-none text-left text-black text-opacity-60 font-light flex items-center"
            v-md.html
            v-html="option.title"
        />
    </label>
</template>

<script>
import { computed, toRefs } from "vue";
export default {
    props: {
        handle: String,
        option: Object,
        modelValue: {
            type: Array,
            default: () => [],
        },
    },
    emits: ["input", "update:modelValue", "change"],
    setup(props, { emit }) {
        const { option, handle } = props;
        const { modelValue } = toRefs(props);

        const update = (val) => {
            emit("input", val);
            emit("update:modelValue", val);
            emit("change", val);
        };

        const selected = computed({
            get() {
                return modelValue.value.includes(option.id);
            },
            set() {
                let newValue = [...modelValue.value];
                if (selected.value) {
                    newValue.splice(newValue.indexOf(option.id), 1);
                } else {
                    newValue.push(option.id);
                }
                update(newValue);
            },
        });

        return {
            handle,
            selected,
            option,
        };
    },
};
</script>

<style>
.select-none p {
    margin: 0;
}
</style>
