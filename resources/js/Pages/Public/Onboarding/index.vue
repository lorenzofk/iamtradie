<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import Public from '@/Layouts/Public.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import Card from 'primevue/card';
import DetailsStep from './Blocks/DetailsStep.vue';
import PricingStep from './Blocks/PricingStep.vue';
import CommunicationStep from './Blocks/CommunicationStep.vue';

defineOptions({
  layout: Public,
});

const { showToast } = useToast();

const props = defineProps({
  selectedPlan: {
    type: String,
    default: 'professional'
  }
});

const currentStep = ref(0);
const isLoaded = ref(false);

const form = useForm({
  user: {
    first_name: 'Dave',
    email: 'dave@miller.com',
    plan: props.selectedPlan,
  },
  settings: {
    business_name: 'Test Business',
    industry_type: 'electrical',
    callout_fee: 120,
    hourly_rate: 85,
    response_tone: 'professional',
  },
});

const steps = [
  { step: 0, title: 'Business Details', icon: 'fa-building' },
  { step: 1, title: 'Pricing Setup', icon: 'fa-dollar-sign' },
  { step: 2, title: 'Communication', icon: 'fa-comments' },
  { step: 3, title: 'Payment', icon: 'fa-credit-card' },
];

const progress = computed(() => ((currentStep.value + 1) / steps.length) * 100);

const nextStep = () => {
  if (currentStep.value < steps.length - 2) {
    currentStep.value++;
  }
};

const prevStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--;
  }
};

const onSubmit = () => {
  var lastStep = currentStep.value === steps.length - 2;

  if (! lastStep) {
    nextStep();
    return;
  }

  form.post(route('checkout'), {
    onError: () => {
      showToast('error', 'Setup failed. Please try again.');
    }
  });
};

setTimeout(() => {
  isLoaded.value = true;
}, 100);
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex items-center justify-center mb-6">
          <div class="bg-gradient-to-r from-blue-600 to-green-600 p-3 rounded-xl mr-4 shadow-lg">
            <font-awesome-icon :icon="['fas', 'fa-bolt']" class="text-white text-2xl" />
          </div>
          <h1 class="text-3xl font-bold text-white">I am Tradie</h1>
        </div>
        <h2 class="text-4xl font-black text-white mb-4">Get Ready to Never Miss Another Lead</h2>
        <p class="text-xl text-blue-100 mb-6">Set up your AI assistant in under 3 minutes</p>
        
        <!-- Progress Bar -->
        <div class="max-w-md mx-auto mb-8">
          <div class="w-full bg-blue-200 rounded-full h-2 mb-3">
            <div 
              class="bg-gradient-to-r from-blue-600 to-green-600 h-2 rounded-full transition-all duration-500"
              :style="{ width: `${progress}%` }"
            ></div>
          </div>
          <p class="text-blue-200 text-sm">
            Step {{ currentStep + 1 }} of {{ steps.length }}: {{ steps[currentStep].title }}
          </p>
        </div>

        <!-- Step Indicators -->
        <div class="flex justify-center space-x-4 mb-8">
          <div 
            v-for="(step, index) in steps" 
            :key="index" 
            class="flex flex-col items-center"
          >
            <div 
              class="w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-300"
              :class="{
                'bg-green-500 border-green-500': index < currentStep,
                'bg-blue-600 border-blue-600': index === currentStep,
                'bg-gray-600 border-gray-600': index > currentStep
              }"
            >
              <font-awesome-icon 
                v-if="index < currentStep"
                :icon="['fas', 'fa-check-circle']" 
                class="w-6 h-6 text-white" 
              />
              <font-awesome-icon 
                v-else
                :icon="['fas', step.icon]" 
                class="w-6 h-6 text-white" 
              />
            </div>
            <span class="text-xs text-blue-200 mt-2 hidden sm:block">
              {{ step.title }}
            </span>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <Card 
        class="shadow-2xl border-0 bg-white/95 backdrop-blur transform transition-all duration-500"
        :class="{ 'translate-y-0 opacity-100': isLoaded, 'translate-y-10 opacity-0': !isLoaded }"
      >
        <template #content>
          <div class="p-8">
            <form @submit.prevent="onSubmit">
              <DetailsStep v-if="currentStep === 0" v-model="form" />
              
              <PricingStep v-if="currentStep === 1" v-model="form" />
              
              <CommunicationStep v-if="currentStep === 2" v-model="form" />

              <hr class="my-8 border-gray-200">

              <!-- Navigation -->
              <div class="flex justify-between">
                <Button
                  type="button"
                  outlined
                  @click="prevStep"
                  :class="{ '!opacity-50 !cursor-not-allowed': currentStep === 0 }"
                  :disabled="currentStep === 0"
                  :icon="['fas', 'fa-arrow-left']"
                  label="Back"
                />

                <Button
                  type="submit"
                  :disabled="form.processing"
                  class="!bg-gradient-to-r !from-blue-600 !to-green-600 hover:!from-blue-700 hover:!to-green-700"
                  :icon="form.processing ? ['fas', 'fa-spinner'] : currentStep === steps.length - 1 ? ['fas', 'fa-check-circle'] : ['fas', 'fa-arrow-right']"
                  :iconPos="currentStep === steps.length - 1 ? 'right' : 'right'"
                  :label="currentStep === steps.length - 2 ? 'Subscribe' : 'Continue'"
                />
              </div>
            </form>
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>