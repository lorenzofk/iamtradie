import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createHead } from '@unhead/vue/client';
import SetupPrimeVue from './Plugins/prime-vue';
import SetupFontAwesome from './Plugins/icons';

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
    console.log('Pages loaded:', Object.keys(pages));
    console.log('Trying to resolve:', name);
    return pages[`./Pages/${name}.vue`]; // check this value
  },
  setup: setupVueApp,
});

window.asset = path => {
  const prefix = import.meta.env.VITE_ASSET_URL || '';

  return prefix.replace(/\/$/, '') + '/' + path.replace(/^\//, '');
};