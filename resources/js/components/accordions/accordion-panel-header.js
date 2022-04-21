import { defineComponent, h, inject, ref } from 'vue';

export default defineComponent({
    name: 'accordion-panel-header',

    inheritAttrs: false,

    props: {
        index: { type: Number, required: true },
        panel_id: { type: String, required: true },
        hasIcon: { type: Boolean, required: false, default: true },
    },

    setup(props, { slots, attrs }) {
        // console.log(attrs);

        const icon = inject('icon');
        const state_classes = inject('state_classes');

        const active_indexes = inject('active_indexes', ref(0));
        const collapsible = inject('collapsible');
        const expandable = inject('expandable');

        const handle_click = () => {
            if (!active_indexes.value.includes(props.index)) {
                if (!expandable) {
                    active_indexes.value = [];
                }

                active_indexes.value.push(props.index);
            } else {
                if (collapsible || (!collapsible && active_indexes.value.length > 1)) {
                    active_indexes.value = active_indexes.value.filter(i => i !== props.index);
                }
            }
        };

        const handle_keydown = event => {
            const current_index = event.target.getAttribute('data-index');
            const accordion = event.target.closest('.accordion');
            let new_child_for_focus = undefined;

            if (event.key === 'ArrowDown') {
                let next_child = accordion.querySelector(
                    `.accordion__panel-header-toggle[data-index="${parseInt(current_index) + 1}"]`,
                );

                if (next_child) {
                    new_child_for_focus = next_child;
                } else {
                    new_child_for_focus = accordion.querySelector(
                        `.accordion__panel:first-child .accordion__panel-header-toggle`,
                    );
                }
            } else if (event.key === 'ArrowUp') {
                let previous_child = accordion.querySelector(
                    `.accordion__panel-header-toggle[data-index="${parseInt(current_index) - 1}"]`,
                );

                if (previous_child) {
                    new_child_for_focus = previous_child;
                } else {
                    new_child_for_focus = accordion.querySelector(
                        `.accordion__panel:last-child .accordion__panel-header-toggle`,
                    );
                }
            } else if (event.key === 'Home') {
                new_child_for_focus = accordion.querySelector(
                    `.accordion__panel:first-child .accordion__panel-header-toggle`,
                );
            } else if (event.key === 'End') {
                new_child_for_focus = accordion.querySelector(
                    `.accordion__panel:last-child .accordion__panel-header-toggle`,
                );
            }

            if (new_child_for_focus) {
                new_child_for_focus.focus();
            }
        };

        return () => {
            const is_active = active_indexes.value.includes(props.index);

            return h(
                'div',
                { class: ['accordion__panel-header', !is_active && state_classes?.inactive?.header, attrs.class || "py-4 px-6"] },
                h(
                    attrs['data-header-tag'] || 'h3',
                    { class: ['accordion__panel-header-heading', attrs['data-font'] || 'text-primary font-bold text-2xl m-0'] },
                    h(
                        'div',
                        {
                            ...attrs,
                            class: ['accordion__panel-header-toggle flex items-center gap-4'].join(' ').trim(),
                            id: `${props.panel_id}-toggle`,
                            'aria-expanded': is_active,
                            'aria-controls': `${props.panel_id}-content`,
                            'aria-disabled': is_active && (!collapsible ? true : false),
                            'data-index': props.index,
                            onClick: handle_click,
                            onKeydown: handle_keydown,
                        },
                        props.hasIcon && h('span', { class: icon.class }, h('i', { class: `fas fa-${!is_active ? icon.active : icon.inactive}` })),
                        slots.default ? slots.default({ isActive: is_active }) : ['Panel Toggle'],
                    ),
                ),
            );
        };
    },
});
