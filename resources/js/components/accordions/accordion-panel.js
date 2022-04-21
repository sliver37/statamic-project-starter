import { defineComponent, h, inject, ref } from 'vue';

export default defineComponent({
    name: 'accordion-panel',

    props: {
        index: { type: Number, required: true },
        hasIcon: { type: Boolean, required: false, default: true }
    },

    setup(props, { slots, attrs }) {
        const active_indexes = inject('active_indexes', ref(0));

        const children = [];

        const panel_header = slots.default
            ? slots
                .default()
                .filter(node => node.type.name === 'accordion-panel-header')
                .shift()
            : null;
        if (panel_header) {
            children.push(panel_header);
        }

        const panel_content = slots.default
            ? slots
                .default()
                .filter(node => node.type.name === 'accordion-panel-content')
                .shift()
            : null;

        if (panel_content) {
            children.push(panel_content);
        }

        return () => {
            const id =
                attrs.id ||
                `tab-${Math.random()
                    .toString(36)
                    .substr(2, 9)}`;

            return h(
                'div',
                {
                    ...attrs,
                    class: [
                        'accordion__panel',
                        active_indexes.value.includes(props.index) ? 'is-active' : '',
                        attrs.class,
                    ]
                        .join(' ')
                        .trim(),
                    id: id,
                },
                children.map(child =>
                    h(child, {
                        index: props.index,
                        panel_id: id,
                        'data-index': props.index,
                        hasIcon: props.hasIcon
                    }),
                ),
            );
        };
    },
});
