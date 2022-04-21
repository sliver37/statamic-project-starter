import { defineComponent, h, inject, ref } from 'vue';

export default defineComponent({
    name: 'hmw-tab-header',

    inheritAttrs: false,

    props: {
        index: { type: Number, required: true },
        panel_id: { type: String, required: true },
    },

    setup(props, { slots, attrs }) {
        const active_index = inject('active_index', ref(0));
        const header_tag = inject('header_tag');
        const collapsible = inject('collapsible');

        const handle_click = () => {
            if (active_index.value !== props.index) {
                active_index.value = props.index;
            }
        };

        const handle_keydown = event => {
            const current_index = event.target.getAttribute('data-index');
            const tab = event.target.closest('.tab');
            let new_child_for_focus = undefined;

            if (event.key === 'ArrowDown') {
                let next_child = tab.querySelector(
                    `.tab__panel-header-toggle[data-index="${parseInt(current_index) + 1}"]`,
                );

                if (next_child) {
                    new_child_for_focus = next_child;
                } else {
                    new_child_for_focus = tab.querySelector(
                        `.tab__panel:first-child .tab__panel-header-toggle`,
                    );
                }
            } else if (event.key === 'ArrowUp') {
                let previous_child = tab.querySelector(
                    `.tab__panel-header-toggle[data-index="${parseInt(current_index) - 1}"]`,
                );

                if (previous_child) {
                    new_child_for_focus = previous_child;
                } else {
                    new_child_for_focus = tab.querySelector(
                        `.tab__panel:last-child .tab__panel-header-toggle`,
                    );
                }
            } else if (event.key === 'Home') {
                new_child_for_focus = tab.querySelector(
                    `.tab__panel:first-child .tab__panel-header-toggle`,
                );
            } else if (event.key === 'End') {
                new_child_for_focus = tab.querySelector(
                    `.tab__panel:last-child .tab__panel-header-toggle`,
                );
            }

            if (new_child_for_focus) {
                new_child_for_focus.focus();
            }
        };

        return () => {
            const is_active = active_index.value === props.index;

            return h(
                'div',
                { class: ['tab__panel-header flex-1 w-full text-center', !is_active && 'cursor-pointer'] },
                h(
                    header_tag,
                    { class: ['tab__panel-header-heading flex-grow font-normal text-xl py-2 px-4 border border-white border-b-0', is_active ? 'bg-gray-100 text-copycolor' : 'text-white'] },
                    h(
                        'div',
                        {
                            ...attrs,
                            class: ['tab__panel-header-toggle', (attrs.class || '')].join(' ').trim(),
                            id: `${props.panel_id}-toggle`,
                            'aria-expanded': is_active,
                            'aria-controls': `${props.panel_id}-content`,
                            'aria-disabled': is_active && (!collapsible ? true : false),
                            'data-index': props.index,
                            onClick: handle_click,
                            onKeydown: handle_keydown,
                        },
                        slots.default ? slots.default({ isActive: is_active }) : ['Panel Toggle'],
                    ),
                ),
            );
        };
    },
});
