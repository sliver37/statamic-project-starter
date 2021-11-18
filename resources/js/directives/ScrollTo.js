export default {
    beforeMount(el, binding, vnode) {

        el.scrollToEvent = function (event) {
            window.scrollTo({
                top: el.offsetTop - (binding.value || 100),
                behavior: 'smooth'
            })
        };
    },
    mounted(el) {
        el.scrollToEvent()
    },
}

