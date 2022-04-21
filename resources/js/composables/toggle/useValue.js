import { toRefs, computed } from 'vue'

export default function useValue(props, context) {
    const { value, modelValue, falseValue, trueValue, middleValue, disabled } = toRefs(props)

    /* istanbul ignore next */
    const externalValue = context.expose !== undefined ? modelValue : value;

    // ============== COMPUTED ==============
    const checked = computed(() => {
        return externalValue.value
    })

    // =============== METHODS ==============

    // no export
    const update = (val) => {
        context.emit('input', val)
        context.emit('update:modelValue', val)
        context.emit('change', val)
    }

    const check = () => {
        update(trueValue.value)
        return trueValue.value
    }

    const middle = () => {
        update(middleValue.value)
    }

    const uncheck = () => {
        update(falseValue.value)
        return falseValue.value
    }

    const handleInput = (val) => {
        update(val.target.checked ? trueValue.value : falseValue.value)
    }

    const handleClick = () => {
        if (disabled.value) {
            return
        }

        checked.value === trueValue.value ? uncheck() : check()
        console.log(externalValue.value)
    }

    // ================ HOOKS ===============

    if ([null, undefined, false, 0, '0', 'off'].indexOf(externalValue.value) !== -1 && externalValue.value !== falseValue.value) {
        uncheck()
    }

    if ([true, 1, '1', 'on'].indexOf(externalValue.value) !== -1 && externalValue.value !== trueValue.value) {
        check()
    }

    return {
        externalValue,
        checked,
        update,
        check,
        middle,
        uncheck,
        handleInput,
        handleClick,
    }
}
