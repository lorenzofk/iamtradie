<script setup>
import Input from '@/Shared/Ui/Form/Input.vue';
import Select from '@/Shared/Ui/Form/Select.vue';

const props = defineProps({
  modelValue: Object,
});

const emit = defineEmits(['update:modelValue']);

const tradeTypes = [
  { label: 'Electrical', value: 'electrical' },
  { label: 'Plumbing', value: 'plumbing' },
  { label: 'Tiling', value: 'tiling' },
  { label: 'Carpentry', value: 'carpentry' },
  { label: 'Painting', value: 'painting' },
  { label: 'Construction', value: 'construction' },
  { label: 'Cleaning', value: 'cleaning' },
  { label: 'Gardening', value: 'gardening' },
  { label: 'Landscaping', value: 'landscaping' },
  { label: 'General', value: 'general' },
];
</script>
<template>
  <div class="space-y-6">
    <div class="text-center mb-8">
      <div
        class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg"
      >
        <font-awesome-icon :icon="['fas', 'fa-building']" class="w-8 h-8 text-white" />
      </div>
      <h3 class="text-2xl font-bold text-gray-900 mb-2">Tell us about your business</h3>
      <p class="text-gray-600">This helps our AI understand your services and create personalized quotes</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Business Name</label>
        <Input
          :model-value="modelValue.settings.business_name"
          @update:model-value="
            val => {
              modelValue.settings.business_name = val;
              emit('update:modelValue', { ...modelValue });
            }
          "
          class="w-full"
          required
        />
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Your First Name</label>
        <Input
          :model-value="modelValue.user.first_name"
          @update:model-value="
            val => {
              modelValue.user.first_name = val;
              emit('update:modelValue', { ...modelValue });
            }
          "
          placeholder="Dave"
          class="w-full"
          required
        />
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
        <Input
          :model-value="modelValue.user.email"
          @update:model-value="
            val => {
              modelValue.user.email = val;
              emit('update:modelValue', { ...modelValue });
            }
          "
          placeholder="dave@miller.com"
          class="w-full"
          required
        />
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Your Trade</label>
        <Select
          :model-value="modelValue.settings.industry_type"
          @update:model-value="
            val => {
              modelValue.settings.industry_type = val;
              emit('update:modelValue', { ...modelValue });
            }
          "
          :options="tradeTypes"
          optionLabel="label"
          optionValue="value"
          placeholder="Select your trade"
          class="w-full"
          required
        />
      </div>
    </div>
  </div>
</template>
