import { defineComponent, h, inject, ref } from 'vue';

export default defineComponent({
    name: 'hmw-tabs-header-tabs',

    props: {
        hasIcon: { type: Boolean, required: false, default: true }
    },

    setup(props, { slots, attrs }) {
        const responsive = inject('responsive');

        const children = [];

        const panel_headers = slots.default
            ? slots
                .default()
                .filter(node => node.type.name === 'hmw-tab-header')
            : null;

        if (panel_headers.length) {
            children.push(...panel_headers);
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
                        'hmw-tabs__header-tabs overflow-hidden flex items-center bg-primary text-white',
                        attrs.class,
                        responsive ? 'flex-col md:flex-row' : 'flex-row'
                    ]
                        .join(' ')
                        .trim(),
                    id: id,
                },
                children.map((child, index) =>
                    h(child, {
                        index: index,
                        panel_id: id,
                        'data-index': index,
                        hasIcon: props.hasIcon
                    }),
                ),
            );
        };
    },
});
