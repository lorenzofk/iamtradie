<script setup>
import { computed } from 'vue';

const props = defineProps({
  color: String,
  modelValue: [Boolean, String, Number, Array],
  value: [String, Number, Array],
  checked: Boolean,
  id: String,
  name: String,
  disabled: Boolean,
});

const emit = defineEmits(['update:modelValue']);

const computedValue = computed({
  get() {
    return props.modelValue;
  },
  set(value) {
    emit('update:modelValue', value);
  },
});
</script>

<style scoped>
input:checked ~ .dot {
  transform: translateX(100%);
  background-color: v-bind(color) !important;
}
</style>

<template>
  <label :for="id" class="flex cursor-pointer items-center">
    <div class="relative">
      <input
        type="checkbox"
        class="sr-only"
        v-model="computedValue"
        :id="id"
        :name="name"
        :disabled="disabled"
        :value="value"
        :checked="checked"
      />
      <div class="block h-6 w-10 rounded-full border border-gray-500"></div>
      <div class="dot absolute left-1 top-1 h-4 w-4 rounded-full bg-gray-300 transition"></div>
    </div>
    <div class="ml-2 font-medium text-gray-600"><slot></slot></div>
  </label>
</template>
