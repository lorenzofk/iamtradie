import { ref, computed, nextTick } from 'vue';

const state = ref(false);

const showLoading = () => {
  state.value = true;
  nextTick();
};

const hideLoading = () => {
  state.value = false;
};

const loading = computed(() => state.value);

export function useLoader() {
  return {
    showLoading,
    hideLoading,
    loading,
  };
}
