import { ref } from 'vue';

const toast = ref(null);

const setToast = toastInstance => {
  toast.value = toastInstance;
};

const showToast = (severity, message, options = {}) => {
  switch (severity) {
    case 'info':
      showInfo(message, options);
      break;
    case 'success':
      showSuccess(message, options);
      break;
    case 'warn':
      showWarn(message, options);
      break;
    case 'error':
      showError(message, options);
      break;
    default:
      throw new Error('Invalid severity type. The options are info, success, warn, and error.');
  }
};

const showInfo = (message, options) => {
  const defaultOptions = {
    severity: 'info',
    summary: 'Info',
    detail: message,
    life: 3000,
  };

  toast.value.add(Object.assign(defaultOptions, options));
};

const showSuccess = (message, options) => {
  const defaultOptions = {
    severity: 'success',
    summary: 'Success',
    detail: message,
    life: 3000,
  };

  toast.value.add(Object.assign(defaultOptions, options));
};

const showWarn = (message, options) => {
  const defaultOptions = {
    severity: 'warn',
    summary: 'Warning',
    detail: message,
    life: 3000,
  };

  toast.value.add(Object.assign(defaultOptions, options));
};

const showError = (message, options) => {
  const defaultOptions = {
    severity: 'error',
    summary: 'Error',
    detail: message || 'An internal server error occurred. Please, try again.',
    life: 3000,
  };

  toast.value.add(Object.assign(defaultOptions, options));
};

const showHttpError = error => {
  if (error?.config?.suppressHttpErrorMsg) {
    return;
  }

  // If the response is a redirect, we don't need to show anything
  if (error?.response?.headers['x-inertia-location']) {
    return;
  }

  // If the request was canceled, we don't need to show anything
  if (error?.code === 'ERR_CANCELED') {
    return;
  }

  // Handle throttled requests separately
  if (error?.status === 429) {
    const timestampUntilReset = error?.response?.headers['x-ratelimit-reset'];
    const timeUntilReset = dayjs.unix(timestampUntilReset);
    const formattedTimeUntilReset = dayjs.duration(dayjs().diff(timeUntilReset)).humanize();

    return showError(`Request throttled. Please, wait ${formattedTimeUntilReset} and try again.`);
  }

  showError(error?.response?.data?.message);
};

export function useToast() {
  return {
    setToast,
    showToast,
    showHttpError,
  };
}
