import { defineComponent, h, inject, onMounted, ref, watch } from 'vue';
import { focusable_elements } from '../../functions/utils';

export default defineComponent({
    name: 'hmw-tab-content',

    props: {
        index: { type: Number, required: true },
        panel_id: { type: String, required: true },
    },

    setup(props, { slots, attrs }) {
        const active_index = inject('active_index', ref(0));

        const panel_ref = ref();

        const set_negative_tabindex_on_focusable_children = () => {
            const focusable_elements_in_panel = panel_ref.value.querySelectorAll(focusable_elements);

            Array.from(focusable_elements_in_panel).forEach(el => el.setAttribute('tabindex', '-1'));
        };

        const restore_tabindex_on_focusable_children = () => {
            const previously_focusable_elements_in_panel = panel_ref.value.querySelectorAll('[tabindex="-1"]');

            Array.from(previously_focusable_elements_in_panel).forEach(el => el.setAttribute('tabindex', '0'));
        };

        onMounted(() => {
            if (active_index.value !== props.index && panel_ref.value) {
                set_negative_tabindex_on_focusable_children();
            }
        });

        watch(
            () => active_index.value,
            (newval, oldval) => {
                if (newval === props.index) {
                    restore_tabindex_on_focusable_children();
                } else if (oldval === props.index) {
                    set_negative_tabindex_on_focusable_children();
                }
            },
        );

        return () =>
            h(
                'div',
                {
                    ...attrs,
                    class: ['tab__panel-content', attrs.class || ''].join(' ').trim(),
                    hidden: active_index.value !== props.index,
                    role: 'region',
                    'aria-labelledby': `${props.panel_id}-toggle`,
                    id: `${props.panel_id}-content`,
                    ref: panel_ref,
                },
                slots.default ? slots.default() : [],
            );
    },
});
