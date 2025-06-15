<script setup>
import Card from 'primevue/card';
import Badge from 'primevue/badge';

const props = defineProps({
  modelValue: Object,
});

const emit = defineEmits(['update:modelValue']);

const communicationStyles = [
  {
    value: 'casual',
    title: 'Casual & Friendly',
    description: 'Relaxed, approachable tone',
    example: "G'day! No worries, I can fix that hot water issue for around $420-580. When works for you?",
  },
  {
    value: 'professional',
    title: 'Professional',
    description: 'Formal, business-like approach',
    example: 'Thank you for contacting us. We can address your hot water repair for $420-580 including callout.',
  },
  {
    value: 'polite',
    title: 'Polite',
    description: 'Polite and professional',
    example: 'Thank you for contacting us. We can address your hot water repair for $420-580 including callout.',
  },
];
</script>

<template>
  <div class="space-y-6">
    <div class="text-center mb-8">
      <div
        class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg"
      >
        <font-awesome-icon :icon="['fas', 'fa-comments']" class="w-8 h-8 text-white" />
      </div>
      <h3 class="text-2xl font-bold text-gray-900 mb-2">Choose your AI's voice</h3>
      <p class="text-gray-600">How should your AI respond to customers?</p>
    </div>
    <div class="space-y-4">
      <Card
        v-for="style in communicationStyles"
        :key="style.value"
        class="cursor-pointer transition-all duration-200 hover:shadow-md border-2"
        :class="{
          'border-blue-500 bg-blue-50 shadow-lg': modelValue.settings.response_tone === style.value,
          'border-gray-300 bg-gray-50 hover:border-gray-400': modelValue.settings.response_tone !== style.value,
        }"
        @click.prevent="
          () => {
            modelValue.settings.response_tone = style.value;
            emit('update:modelValue', { ...modelValue });
          }
        "
      >
        <template #content>
          <div class="p-6">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 mt-1">
                <div
                  class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
                  :class="{
                    'border-blue-500 bg-blue-500': modelValue.settings.response_tone === style.value,
                    'border-gray-400 bg-white': modelValue.settings.response_tone !== style.value,
                  }"
                >
                  <font-awesome-icon
                    v-if="modelValue.settings.response_tone === style.value"
                    :icon="['fas', 'fa-check']"
                    class="w-3 h-3 text-white"
                  />
                </div>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                  <h4 class="font-semibold text-lg text-gray-900">{{ style.title }}</h4>
                  <Badge
                    v-if="modelValue.settings.response_tone === style.value"
                    value="Selected"
                    severity="success"
                    class="text-xs"
                  />
                </div>
                <p class="text-gray-600 mb-3">{{ style.description }}</p>
                <div
                  class="p-4 rounded-lg border"
                  :class="{
                    'bg-blue-100 border-blue-200': modelValue.settings.response_tone === style.value,
                    'bg-white border-gray-200': modelValue.settings.response_tone !== style.value,
                  }"
                >
                  <p class="text-sm italic text-gray-700">{{ style.example }}</p>
                </div>
              </div>
            </div>
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>
