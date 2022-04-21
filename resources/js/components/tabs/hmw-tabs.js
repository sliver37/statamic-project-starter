import { defineComponent, h, provide, ref, watch, onMounted } from 'vue';
import { useUrlSearchParams } from '@vueuse/core';

export default defineComponent({
    props: {
        modelValue: { type: Number, required: false, default: 0 },
        headerTag: { type: String, required: false, default: 'h3' },
        collapsible: { type: Boolean, required: false, default: false },
        responsive: { type: Boolean, required: false, default: false },
        hasIcon: { type: Boolean, required: false, default: true },
    },

    setup(props, { emit, slots, attrs }) {
        const active_index = ref(props.modelValue);
        const URL = useUrlSearchParams();

        provide('active_index', active_index);
        provide('responsive', props.responsive);
        provide('header_tag', props.headerTag);
        provide('collapsible', props.collapsible);

        watch(
            () => active_index.value,
            (newval, oldval) => {
                if (newval !== undefined && newval !== oldval && newval !== props.modelValue) {
                    emit('update:modelValue', newval);
                    URL.active_tab = newval;
                }
            },
        );

        watch(
            () => props.modelValue,
            (newval, oldval) => {
                if (
                    newval !== undefined &&
                    oldval &&
                    newval !== oldval &&
                    newval !== active_index.value
                ) {
                    active_index.value = newval;

                }
            },
            {
                immediate: true,
            },
        );

        onMounted(() => {
            if (URL.active_tab !== undefined) {
                active_index.value = parseInt(URL.active_tab);
                console.log(active_index.value)
            }
        })

        const get_groups = (node_type) => {
            let default_slot = slots.default ? slots.default() : [];

            let groups = [];

            default_slot
                .filter(
                    node =>
                        node.type.name === node_type ||
                        (typeof node.type === 'symbol' && node.type.description === 'Fragment'),
                )
                .forEach(node => {
                    if (typeof node.type === 'symbol' && node.type.description === 'Fragment') {
                        groups = groups.concat(
                            node.children.filter(vnode => vnode.type.name === node_type),
                        );
                    } else {
                        groups.push(node);
                    }
                });

            return groups;
        };

        return () => {
            let tab_header_tabs = get_groups('hmw-tabs-header-tabs');
            let tab_content_panels = get_groups('hmw-tabs-content-panels');

            return h(
                'div',
                {
                    ...attrs,
                    class: 'tabs',
                },
                tab_header_tabs.map((child) =>
                    h(child, { hasIcon: props.hasIcon }),
                ),
                tab_content_panels.map((child) =>
                    h(child, { hasIcon: props.hasIcon }),
                ),
            );
        };
    },
});
