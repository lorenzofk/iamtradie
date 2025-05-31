import PrimeVue from 'primevue/config';
import Tooltip from 'primevue/tooltip';
import ConfirmationService from 'primevue/confirmationservice';
import DialogService from 'primevue/dialogservice';
import ToastService from 'primevue/toastservice';
import Aura from '@primeuix/themes/aura';

export default function SetupPrimeVue(app) {
  app
    .use(PrimeVue, {
      theme: {
        preset: Aura,
        options: {
          darkModeSelector: '.dark-mode', // Disables dark-mode
        },
      },
      ripple: true,
    })
    .use(ConfirmationService)
    .use(DialogService)
    .use(ToastService)
    .directive('tooltip', Tooltip);

  return app;
}
