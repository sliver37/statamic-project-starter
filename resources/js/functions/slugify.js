const addSlug = (item) => {
    item.slug = item.title.toLowerCase()
    return item
}

const recurse = (items) => {
    for (let i = 0; i < items.length; i++) {
        addSlug(items[i])
        if (items[i].children) {
            recurse(items[i].children)
        }
    }
}

export default function (items) {
    recurse(items)
    return items
}
