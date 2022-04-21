<template>
    <div class="radio-group">
        <slot name="before-input" />
        <div
            class="radio-group__options"
            :class="{ 'column-count-2': options.length > 5 }"
        >
            <label class="custom-label py-2" tabindex="0">
                <input
                    class="px-7"
                    step="1"
                    :name="handle"
                    :max="optionsArray[optionsArray.length - 1][1]"
                    :min="0"
                    type="range"
                    v-model="selected"
                />
                <div class="flex px-8 justify-between">
                    <span
                        @click="setStep(0)"
                        class="select-none cursor-pointer text-left"
                        >All</span
                    >
                    <span
                        v-for="(option, i) in optionsArray"
                        :key="option[1] + i"
                        @click="setStep(option[0])"
                        class="select-none cursor-pointer text-left"
                        v-md.html
                        v-html="option[1]"
                    />
                </div>
            </label>
        </div>
        <slot name="after-input" />
    </div>
</template>

<script>
import { computed, toRefs, onMounted } from "vue";
export default {
    props: {
        options: {
            type: Object,
            required: false,
        },
        old: {
            type: Object,
        },
        handle: {
            type: String,
            required: false,
            default: "",
        },
        columns: {
            type: String,
            required: false,
            default: "",
        },
        modelValue: {
            type: [String, Number],
            default: "",
        },
    },
    emits: ["input", "update:modelValue"],
    setup(props, context) {
        const { options, old, handle, columns } = props;
        const { modelValue } = toRefs(props);

        const selected = computed({
            get() {
                const item = optionsArray.find((el) =>
                    el.includes(modelValue.value)
                );
                return item ? item[1] : 0;
            },
            set(e) {
                handleCheck(e);
            },
        });

        const optionsArray = options
            ? Object.entries(options).reduce((acc, [key, val]) => {
                  let arr = [];
                  if (val.hasOwnProperty("id")) {
                      arr.push(key);
                      arr.push(val.title);
                  } else {
                      console.log({ key, val });
                      arr.push(key);
                      arr.push(val);
                  }
                  acc.push(arr);
                  return acc;
              }, [])
            : null;

        const handleCheck = (val) => {
            context.emit("update:modelValue", val);
            context.emit("input", val);
        };

        const setStep = (step) => {
            selected.value = step;
        };

        onMounted(() => {
            if (old) {
                selected.value = Array.isArray(old) ? old[0] : old;
                handleCheck();
            }
        });

        return {
            optionsArray,
            selected,
            setStep,
            handle,
            handleCheck,
        };
    },
};
</script>

<style>
.custom-label input:checked + span {
    display: block !important;
}

span > p:last-child {
    margin: 0;
}
</style>
