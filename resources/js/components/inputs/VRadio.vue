<template>
    <div class="radio-group">
        <slot name="before-input" />
        <div
            class="radio-group__options"
            :class="{ 'column-count-2': options.length > 5 }"
        >
            <label
                class="custom-label flex py-2"
                v-for="(option, i) in optionsArray"
                :key="handle + i"
                tabindex="0"
            >
                <div
                    class="radio-bg border w-7 h-7 p-1 rounded-full flex justify-center items-center mr-2 flex-shrink-0"
                >
                    <input
                        type="radio"
                        :name="handle"
                        v-model="selected"
                        :value="option[0]"
                        class="hidden"
                    />
                    <span
                        class="bg-secondary hidden rounded-full w-2 h-2 text-secondary pointer-events-none"
                        viewBox="0 0 172 172"
                    ></span>
                </div>
                <span
                    class="select-none text-left"
                    v-md.html
                    v-html="option[1]"
                />
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
            type: String,
            default: "",
        },
    },
    emits: ["input", "update:modelValue"],
    setup(props, context) {
        const { options, old, handle, columns } = props;
        const { modelValue } = toRefs(props);

        const selected = computed({
            get() {
                return modelValue.value;
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

        onMounted(() => {
            if (old) {
                selected.value = Array.isArray(old) ? old[0] : old;
                handleCheck();
            }
        });

        return {
            optionsArray,
            selected,
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
