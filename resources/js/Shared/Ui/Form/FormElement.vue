<script setup>
import { useId } from 'vue';
import FormLabel from './FormLabel.vue';

defineOptions({
  name: 'FormElement',
});

defineProps({
  label: String,
  required: Boolean,
  error: String,
});

const id = useId();
</script>

<template>
  <div class="flex flex-col">
    <div v-if="label">
      <FormLabel :id="id" :required="required" :class="{ 'text-red-500': error?.length }">
        {{ label }}
      </FormLabel>
    </div>

    <slot :id="id" />
    <small v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</small>
  </div>
</template>
