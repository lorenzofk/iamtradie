<template>
  <Password toggleMask :feedback="feedback">
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </Password>
</template>

<script setup>
import Password from 'primevue/password';

defineProps({
  feedback: {
    type: Boolean,
    default: false,
  },
});
</script>

<style scoped>
:deep(.p-inputtext) {
  @apply !w-full;
}
</style>
