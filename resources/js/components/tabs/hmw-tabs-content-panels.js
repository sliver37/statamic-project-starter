import { defineComponent, h, inject, ref } from 'vue';

export default defineComponent({
    name: 'hmw-tabs-content-panels',

    props: {
        hasIcon: { type: Boolean, required: false, default: true }
    },

    setup(props, { slots, attrs }) {
        const children = [];

        const panel_content = slots.default
            ? slots
                .default()
                .filter(node => node.type.name === 'hmw-tab-content')
            : null;

        if (panel_content.length) {
            children.push(...panel_content);
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
                        'hmw_tabs__content-panels py-6 px-8 bg-gray-100',
                        attrs.class,
                    ]
                        .join(' ')
                        .trim(),
                    id: id,
                },
                children.map((child, index) =>
                    h(child, {
                        index,
                        panel_id: id,
                        'data-index': index,
                        hasIcon: props.hasIcon
                    }),
                ),
            );
        };
    },
});
