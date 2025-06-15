<script setup>
import { useHead } from '@unhead/vue';
import { useToast as PrimeVueUseToast } from 'primevue/usetoast';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import Toast from '@Shared/Ui/Messages/Toast.vue';

const { setToast } = useToast();

const props = defineProps({
  layout: Object,
});

useHead({
  title: () => (props.layout?.title ? `PingMate :: ${props.layout.title}` : 'PingMate - Never Miss a Lead'),
});

setToast(PrimeVueUseToast());
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Toast />
    <main class="flex-1">
      <slot />
    </main>
  </div>
</template>
