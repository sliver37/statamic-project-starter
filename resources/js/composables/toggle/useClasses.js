import { computed, toRefs } from 'vue'

export default function useClasses(props, context, dependencies) {
    const refs = toRefs(props)
    const disabled = refs.disabled.value
    const classes = {
        container: 'inline-block outline-none',
        toggle: 'bg-white flex w-16 h-5 border-tertiary rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
        toggleOn: 'justify-start text-white',
        toggleMiddle: 'toggle-middle',
        toggleOff: 'border-gray-200 justify-end text-gray-700',
        toggleOnDisabled: 'bg-gray-300 border-gray-300 justify-start text-gray-400 cursor-not-allowed',
        toggleOffDisabled: 'bg-gray-200 border-gray-200 justify-end text-gray-400 cursor-not-allowed',
        handle: 'inline-block border-2 border-white w-4 h-4 top-0 rounded-full absolute transition-all',
        handleOn: 'left-full bg-secondary transform -translate-x-full',
        handleMiddle: 'toggle-handle-middle bg-tertiary',
        handleOff: 'left-0 bg-black',
        handleOnDisabled: 'bg-gray-100 left-full transform -translate-x-full',
        handleOffDisabled: 'bg-gray-100 left-0',
        label: 'text-center w-8 border-box whitespace-nowrap select-none',
        ...refs.classes.value,
    }

    // ============ DEPENDENCIES ============

    const checked = dependencies.checked

    // ============== COMPUTED ==============

    const classList = computed(() => {
        return {
            container: classes.container,
            toggle: [
                classes.toggle,
                disabled
                    ? (checked.value ? classes.toggleOnDisabled : classes.toggleOffDisabled)
                    : (checked.value === refs.trueValue.value && classes.toggleOn) || (checked.value === refs.middleValue.value && classes.toggleMiddle) || (checked.value === refs.falseValue.value && classes.toggleOff)
            ],
            handle: [
                classes.handle,
                disabled
                    ? (checked.value ? classes.handleOnDisabled : classes.handleOffDisabled)
                    : (checked.value === refs.trueValue.value && classes.handleOn) || (checked.value === refs.middleValue.value && classes.handleMiddle) || (checked.value === refs.falseValue.value && classes.handleOff)
            ],
            label: classes.label,
        }
    })

    return {
        classList,
    }
}
