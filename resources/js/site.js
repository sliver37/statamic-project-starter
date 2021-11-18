// This is all you.
import { createApp } from "vue";

// We can parse markdown with the v-md directive
import VueMarkdown from './directives/Markdown'

// This will trigger a callback if we have clicked outside of the element v-click-outside is on
import ClickOutside from './directives/ClickOutside'

// Whenever this element exists on page (or on load), it will scroll to that element
import ScrollTo from './directives/ScrollTo'

// The custom accordion class for all of the accordion components in use by theme and buildamic
// import accordions from './accordion'

// Make the header hide/show based on scroll direction (mobile)
import ToggleOnScroll from './directives/ToggleOnScroll.js';

// Find any links inside the text and URLify them
import URLifyText from './directives/URLifyText.js';

// This is for implementing modals, toasts, or info toggles
// import Popper from "vue3-popper";

// Lightweight scroll animation library
// import sal from 'sal.js';
// import 'sal.js/dist/sal.css';

// require('./functions/globals');

// import 'eva-icons/style/eva-icons.css'

// Glob and register all of the components
const filesRecursive = require.context('./components', true, /\.vue$/i)

const app = createApp({})

app.directive('md', VueMarkdown)
app.directive('click-outside', ClickOutside)
app.directive('scroll-to', ScrollTo)
app.directive('toggle-on-scroll', ToggleOnScroll)
app.directive('urlify-text', URLifyText)

// app.config.compilerOptions.isCustomElement = tag => tag.startsWith('x-')

// The registration part of the glob
filesRecursive.keys().map(key => {
    let name = key.split('/').pop().split('.')[0];
    app.component(name, filesRecursive(key).default)
})

// app.component('Popper', Popper)

app.mount("#app")

// window.addEventListener('load', () => {
//     accordions();
//     sal({
//       threshold: .1
//     });
// })

