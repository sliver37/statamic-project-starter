import { defineComponent, h, provide, ref, toRefs, watch } from 'vue';

export default defineComponent({
    props: {
        modelValue: { type: Array, required: false, default: () => [] },
        collapsible: { type: Boolean, required: false, default: true },
        expandable: { type: Boolean, required: false, default: false },
        hasIcon: { type: Boolean, required: false, default: true },
        state_classes: {
            type: Object, required: false, default: () => { }
        },
        icon: { type: Object, required: false, default: () => ({ active: 'plus', inactive: 'minus', class: 'inline-flex items-center justify-center bg-primary rounded-full p-2 w-8 h-8 text-white text-sm', order: 0 }) },
    },

    setup(props, { emit, slots, attrs }) {
        const active_indexes = ref(props.modelValue.slice());

        // MakeZ
        const state_classes = {
            inactive: {
                header: 'bg-gray-100'
            },
            ...props.state_classes,
        }

        provide('state_classes', state_classes);
        provide('icon', props.icon);

        provide('active_indexes', active_indexes);
        provide('collapsible', props.collapsible);
        provide('expandable', props.expandable);

        watch(
            () => active_indexes.value,
            (newval, oldval) => {
                if (newval && newval.join('') !== oldval.join('') && newval.join('') !== props.modelValue.join('')) {
                    emit('update:modelValue', newval.slice());
                }
            },
        );

        watch(
            () => props.modelValue,
            (newval, oldval) => {
                if (
                    newval &&
                    oldval &&
                    newval.join('') !== oldval.join('') &&
                    newval.join('') !== active_indexes.value.join('')
                ) {
                    active_indexes.value = newval;
                }
            },
            {
                immediate: true,
            },
        );

        const get_accordion_groups = () => {
            let default_slot = slots.default ? slots.default() : [];

            let accordion_groups = [];

            default_slot
                .filter(
                    node =>
                        node.type.name === 'accordion-panel' ||
                        (typeof node.type === 'symbol' && node.type.description === 'Fragment'),
                )
                .forEach(node => {
                    if (typeof node.type === 'symbol' && node.type.description === 'Fragment') {
                        accordion_groups = accordion_groups.concat(
                            node.children.filter(vnode => vnode.type.name === 'accordion-panel'),
                        );
                    } else {
                        accordion_groups.push(node);
                    }
                });

            return accordion_groups;
        };

        return () => {
            let accordion_groups = get_accordion_groups();

            return h(
                'div',
                {
                    ...attrs,
                    class: 'accordion flex flex-col gap-6',
                },
                accordion_groups.map((child, child_index) =>
                    h(child, { index: child_index, 'data-index': child_index, hasIcon: props.hasIcon }),
                ),
            );
        };
    },
});
