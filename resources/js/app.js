import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createHead } from '@unhead/vue/client';
import SetupPrimeVue from './Plugins/prime-vue';
import SetupFontAwesome from './Plugins/icons';
import axios from 'axios';

const setupVueApp = ({ el, App, props, plugin }) => {
  const head = createHead();
  const app = createApp({ render: () => h(App, props) }).use(plugin);

  app.use(head);

  app.mixin({
    methods: {
      asset: window.asset,
    },
  });

  SetupPrimeVue(app);
  SetupFontAwesome(app);

  if (window.route) {
    app.mixin({ methods: { route: window.route } });
  }
  
  app.mount(el);
};

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    return pages[`./Pages/${name}.vue`];
  },
  setup: setupVueApp,
});

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.asset = path => {
  const prefix = import.meta.env.VITE_ASSET_URL || '';

  return prefix.replace(/\/$/, '') + '/' + path.replace(/^\//, '');
};