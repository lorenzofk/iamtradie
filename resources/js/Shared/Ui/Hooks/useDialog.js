import { ref } from 'vue';

const confirm = ref(null);

const setConfirmDialog = instance => {
  confirm.value = instance;
};

const showConfirmDialog = (severity, options = {}) => {
  const defaultOptions = {
    blockScroll: true,
    acceptProps: {
      severity,
      label: options.acceptLabel || 'OK',
    },
    rejectProps: {
      plain: true,
      text: true,
      label: options.rejectLabel || 'Cancel',
    },
  };

  if (options.html) {
    defaultOptions.group = 'with-html';
  }

  confirm.value.require(Object.assign(defaultOptions, options));
};

const showInfoDialog = (options = {}) => {
  showConfirmDialog('info', {
    acceptLabel: 'OK',
    ...options,
    rejectClass: 'hidden',
  });
};

export function useDialog() {
  return {
    setConfirmDialog,
    showConfirmDialog,
    showInfoDialog,
  };
}
