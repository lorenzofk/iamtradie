<script setup>
import Message from 'primevue/message';
</script>

<template>
  <Message class="my-6">
    <template #icon>
      <font-awesome-icon
        v-if="$attrs.severity === 'info'"
        :icon="['fas', 'info-circle']"
        class="mr-3 text-2xl"
        :style="{ color: '#1e40af' }"
      />
      <font-awesome-icon
        v-if="$attrs.severity === 'error'"
        :icon="['fas', 'exclamation-circle']"
        class="mr-3 text-2xl text-red-800"
      />
    </template>
    <slot />
  </Message>
</template>

<style scoped>
:deep(.p-message-content) {
  @apply py-4 px-6;
}

:deep(.p-message-content .p-message-text) {
  @apply font-light;
}

.p-message-info {
  @apply text-black;
}

.p-message-error {
  @apply bg-red-200;
  @apply text-red-800;
}
</style>
