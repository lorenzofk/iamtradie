import PrimeVue from 'primevue/config';
import Tooltip from 'primevue/tooltip';
import ConfirmationService from 'primevue/confirmationservice';
import DialogService from 'primevue/dialogservice';
import ToastService from 'primevue/toastservice';
import Aura from '@primeuix/themes/aura';
import { updatePrimaryPalette } from '@primeuix/themes';

// Set your custom palette for Aura theme
updatePrimaryPalette({
  50: '#f5f7ff',
  100: '#e3e8fd',
  200: '#bfc8fa',
  300: '#8a9cf6',
  400: '#536dfe',
  500: '#1a237e',
  600: '#16206b',
  700: '#121a57',
  800: '#0c1446',
  900: '#080e2c',
});

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
