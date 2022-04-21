import { createApp } from "vue";

const app = createApp({})

// Google Map Component
import VueGoogleMaps from '@fawmi/vue-google-maps'
app.use(VueGoogleMaps, {
    load: {
        key: 'API_KEY_HERE',
    },
})

// Accordions
import Accordion from './components/accordions/accordion';
import AccordionPanel from './components/accordions/accordion-panel';
import AccordionPanelHeader from './components/accordions/accordion-panel-header';
import AccordionPanelContent from './components/accordions/accordion-panel-content';
app.component('accordion', Accordion);
app.component('accordion-panel', AccordionPanel);
app.component('accordion-panel-header', AccordionPanelHeader);
app.component('accordion-panel-content', AccordionPanelContent);

// Tabs
import HmwTabs from './components/tabs/hmw-tabs';
import HmwTabsHeaderTabs from './components/tabs/hmw-tabs-header-tabs';
import HmwTabsContentPanels from './components/tabs/hmw-tabs-content-panels';
import HmwTabHeader from './components/tabs/hmw-tab-header';
import HmwTabContent from './components/tabs/hmw-tab-content';
app.component('hmw-tabs', HmwTabs);
app.component('hmw-tabs-header-tabs', HmwTabsHeaderTabs);
app.component('hmw-tabs-content-panels', HmwTabsContentPanels);
app.component('hmw-tab-header', HmwTabHeader);
app.component('hmw-tab-content', HmwTabContent);

// Youtube Iframe API
import YoutubeIframeAPI from "./components/videos/YoutubeIframeAPI";
app.component('youtube', YoutubeIframeAPI);

// Make the header hide/show based on scroll direction (mobile)
import ToggleOnScroll from './directives/ToggleOnScroll.js';
app.directive('toggle-on-scroll', ToggleOnScroll)

// Laravel SVG Vue
// import SvgVue from 'svg-vue3';
// app.use(SvgVue);

// Glob and register all of the components
const filesRecursive = require.context('./components', true, /\.vue$/i)
filesRecursive.keys().map(key => {
    let name = key.split('/').pop().split('.')[0];
    app.component(name, filesRecursive(key).default)
})

// Social share icons
import VueSocialSharing from 'vue-social-sharing'
app.use(VueSocialSharing);

app.mount("#app")

import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';

window.addEventListener('load', () => {
    const lightbox = GLightbox({
        selector: ".glightbox"
    });
})

