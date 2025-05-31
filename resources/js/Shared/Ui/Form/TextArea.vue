<script setup>
import { onMounted, ref } from 'vue';
import Textarea from 'primevue/textarea';

defineOptions({
  name: 'TextArea',
});

const props = defineProps({
  autoResize: Boolean,
});

const autoResizeTextArea = ref(false);

onMounted(() => {
  // Due to a bug in PrimeVue, we need to set the autoResize property
  // after the component is mounted
  if (props.autoResize) {
    autoResizeTextArea.value = true;
  }
});
</script>

<template>
  <Textarea :autoResize="autoResizeTextArea" />
</template>
