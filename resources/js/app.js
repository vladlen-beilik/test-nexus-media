import '../css/app.css'
import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import axios from 'axios'
import VueClickAway from 'vue3-click-away';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/*.vue', {eager: true})
        return pages[`./Pages/${name}.vue`]
    },
    title: title => title ? `${title} - Test NexusMedia` : 'Test NexusMedia',
    setup({el, App, props, plugin}) {
        const app = createApp({render: () => h(App, props)});
        app.use(plugin);
        app.use(VueClickAway);
        app.mount(el);
    },
})
