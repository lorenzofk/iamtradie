<script setup>
defineProps({
  required: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <label class="mb-2 text-sm font-medium">
    <slot />
    <span class="ml-1 text-red-600" v-if="required">*</span>
  </label>
</template>
