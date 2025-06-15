<script setup>
import Card from 'primevue/card';

const props = defineProps({
  modelValue: Object,
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
  <div class="space-y-8">
    <div class="text-center mb-8">
      <div
        class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg"
      >
        <font-awesome-icon :icon="['fas', 'fa-dollar-sign']" class="w-8 h-8 text-white" />
      </div>
      <h3 class="text-2xl font-bold text-gray-900 mb-2">Set your pricing</h3>
      <p class="text-gray-600">Your AI will use these rates to generate accurate quotes</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <Card class="border-2 border-blue-200 bg-blue-50">
        <template #header>
          <div class="text-center pt-6">
            <h4 class="text-lg font-semibold text-gray-900">Callout Fee</h4>
            <div class="text-3xl font-bold text-blue-600">${{ modelValue.settings.callout_fee }}</div>
          </div>
        </template>
        <template #content>
          <div class="px-6 pb-6">
            <input
              type="range"
              :value="modelValue.settings.callout_fee"
              @input="
                e => {
                  modelValue.settings.callout_fee = Number(e.target.value);
                  emit('update:modelValue', { ...modelValue });
                }
              "
              min="10"
              max="500"
              step="10"
              class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer"
            />
            <p class="text-sm text-gray-600 text-center mt-3">Includes travel and initial assessment</p>
          </div>
        </template>
      </Card>
      <Card class="border-2 border-green-200 bg-green-50">
        <template #header>
          <div class="text-center pt-6">
            <h4 class="text-lg font-semibold text-gray-900">Hourly Rate</h4>
            <div class="text-3xl font-bold text-green-600">${{ modelValue.settings.hourly_rate }}</div>
          </div>
        </template>
        <template #content>
          <div class="px-6 pb-6">
            <input
              type="range"
              :value="modelValue.settings.hourly_rate"
              @input="
                e => {
                  modelValue.settings.hourly_rate = Number(e.target.value);
                  emit('update:modelValue', { ...modelValue });
                }
              "
              min="40"
              max="300"
              step="5"
              class="w-full h-2 bg-green-200 rounded-lg appearance-none cursor-pointer"
            />
            <p class="text-sm text-gray-600 text-center mt-3">Standard labor rate per hour</p>
          </div>
        </template>
      </Card>
    </div>
    <div class="bg-blue-50 p-6 rounded-xl">
      <h4 class="font-semibold text-gray-900 mb-3">Quote Preview</h4>
      <div class="bg-white p-4 rounded-lg border">
        <p class="text-sm text-gray-700">
          <strong>Sample quote:</strong>
          "Hi! For your electrical repair, it's ${{ modelValue.settings.callout_fee }} callout + ${{
            modelValue.settings.hourly_rate
          }}/hour for labor. Estimated total: ${{
            modelValue.settings.callout_fee + modelValue.settings.hourly_rate * 2
          }}- ${{ modelValue.settings.callout_fee + modelValue.settings.hourly_rate * 4 }} (2-4 hours work). When works
          best for you?"
        </p>
      </div>
    </div>
  </div>
</template>
