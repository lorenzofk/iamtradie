<script setup>
import { ref, computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import Public from '@/Layouts/Public.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import Input from '@/Shared/Ui/Form/Input.vue';
import Select from '@/Shared/Ui/Form/Select.vue';
import Textarea from '@/Shared/Ui/Form/Textarea.vue';
import Card from 'primevue/card';
import Badge from 'primevue/badge';

defineOptions({
  layout: Public,
});

const props = defineProps({
  selectedPlan: {
    type: String,
    default: 'professional'
  }
});

const { showToast } = useToast();
const currentStep = ref(0);
const isLoaded = ref(false);

const form = useForm({
  businessName: '',
  firstName: '',
  tradeType: '',
  serviceArea: '',
  calloutFee: 120,
  hourlyRate: 85,
  communicationStyle: 'professional',
  customGreeting: '',
  plan: props.selectedPlan,
});

const tradeTypes = [
  { label: 'Electrician', value: 'electrician' },
  { label: 'Plumber', value: 'plumber' },
  { label: 'HVAC Technician', value: 'hvac' },
  { label: 'Handyman', value: 'handyman' },
  { label: 'Cleaner', value: 'cleaner' },
  { label: 'Painter', value: 'painter' },
  { label: 'Gardener/Landscaper', value: 'gardener' },
  { label: 'Other', value: 'other' }
];

const communicationStyles = [
  {
    value: 'casual',
    title: 'Casual & Friendly',
    description: 'Relaxed, approachable tone',
    example: 'G\'day! No worries, I can fix that hot water issue for around $420-580. When works for you?'
  },
  {
    value: 'professional',
    title: 'Professional',
    description: 'Formal, business-like approach',
    example: 'Thank you for contacting us. We can address your hot water repair for $420-580 including callout.'
  },
  {
    value: 'friendly',
    title: 'Friendly Professional',
    description: 'Warm but professional',
    example: 'Hi there! Happy to help with your hot water repair. Cost would be around $420-580 including callout.'
  }
];

const steps = [
  { title: 'Business Details', icon: 'fa-building' },
  { title: 'Pricing Setup', icon: 'fa-dollar-sign' },
  { title: 'Communication', icon: 'fa-comments' },
  { title: 'Payment', icon: 'fa-credit-card' },
  { title: 'Phone Setup', icon: 'fa-phone' },
];

const progress = computed(() => ((currentStep.value + 1) / steps.length) * 100);

const nextStep = () => {
  if (currentStep.value < steps.length - 1) {
    currentStep.value++;
  }
};

const prevStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--;
  }
};

const onSubmit = () => {
  if (currentStep.value === steps.length - 1) {
    form.post(route('onboarding.complete'), {
      onSuccess: () => {
        showToast('success', 'Welcome to I am Tradie! Your AI assistant is ready to capture leads.');
        router.visit(route('dashboard'));
      },
      onError: () => {
        showToast('error', 'Setup failed. Please try again.');
      }
    });
  } else {
    nextStep();
  }
};

const planPricing = {
  starter: { price: 47, features: ['100 SMS/month', 'Basic AI', 'Email support'] },
  professional: { price: 97, features: ['Unlimited SMS', 'Advanced AI', 'Priority support', 'Custom branding'] },
  enterprise: { price: 197, features: ['Everything in Pro', 'Multiple numbers', 'API access', 'Dedicated support'] }
};

// Animation on mount
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
              
              <!-- Step 1: Business Details -->
              <div v-if="currentStep === 0" class="space-y-6">
                <div class="text-center mb-8">
                  <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <font-awesome-icon :icon="['fas', 'fa-building']" class="w-8 h-8 text-white" />
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 mb-2">Tell us about your business</h3>
                  <p class="text-gray-600">This helps our AI understand your services and create personalized quotes</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Business Name</label>
                    <Input
                      v-model="form.businessName"
                      placeholder="Miller Electrical Services"
                      class="w-full"
                      required
                    />
                  </div>

                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your First Name</label>
                    <Input
                      v-model="form.firstName"
                      placeholder="Dave"
                      class="w-full"
                      required
                    />
                  </div>

                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Trade</label>
                    <Select 
                      v-model="form.tradeType" 
                      :options="tradeTypes" 
                      optionLabel="label" 
                      optionValue="value"
                      placeholder="Select your trade" 
                      class="w-full"
                      required
                    />
                  </div>

                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Service Area</label>
                    <Input
                      v-model="form.serviceArea"
                      placeholder="Sydney Metro"
                      class="w-full"
                      required
                    />
                  </div>
                </div>
              </div>

              <!-- Step 2: Pricing Setup -->
              <div v-if="currentStep === 1" class="space-y-8">
                <div class="text-center mb-8">
                  <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
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
                        <div class="text-3xl font-bold text-blue-600">
                          ${{ form.calloutFee }}
                        </div>
                      </div>
                    </template>
                    <template #content>
                      <div class="px-6 pb-6">
                        <input
                          type="range"
                          v-model.number="form.calloutFee"
                          min="50"
                          max="500"
                          step="10"
                          class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer"
                        />
                        <p class="text-sm text-gray-600 text-center mt-3">
                          Includes travel and initial assessment
                        </p>
                      </div>
                    </template>
                  </Card>

                  <Card class="border-2 border-green-200 bg-green-50">
                    <template #header>
                      <div class="text-center pt-6">
                        <h4 class="text-lg font-semibold text-gray-900">Hourly Rate</h4>
                        <div class="text-3xl font-bold text-green-600">
                          ${{ form.hourlyRate }}
                        </div>
                      </div>
                    </template>
                    <template #content>
                      <div class="px-6 pb-6">
                        <input
                          type="range"
                          v-model.number="form.hourlyRate"
                          min="40"
                          max="300"
                          step="5"
                          class="w-full h-2 bg-green-200 rounded-lg appearance-none cursor-pointer"
                        />
                        <p class="text-sm text-gray-600 text-center mt-3">
                          Standard labor rate per hour
                        </p>
                      </div>
                    </template>
                  </Card>
                </div>

                <div class="bg-blue-50 p-6 rounded-xl">
                  <h4 class="font-semibold text-gray-900 mb-3">Quote Preview</h4>
                  <div class="bg-white p-4 rounded-lg border">
                    <p class="text-sm text-gray-700">
                      <strong>Sample quote:</strong> "Hi! For your electrical repair, it's ${{ form.calloutFee }} callout + 
                      ${{ form.hourlyRate }}/hour for labor. Estimated total: ${{ form.calloutFee + form.hourlyRate * 2 }}-
                      ${{ form.calloutFee + form.hourlyRate * 4 }} (2-4 hours work). When works best for you?"
                    </p>
                  </div>
                </div>
              </div>

              <!-- Step 3: Communication Style -->
              <div v-if="currentStep === 2" class="space-y-6">
                <div class="text-center mb-8">
                  <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
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
                      'border-blue-500 bg-blue-50 shadow-lg': form.communicationStyle === style.value,
                      'border-gray-300 bg-gray-50 hover:border-gray-400': form.communicationStyle !== style.value
                    }"
                    @click="form.communicationStyle = style.value"
                  >
                    <template #content>
                      <div class="p-6">
                        <div class="flex items-start space-x-4">
                          <div class="flex-shrink-0 mt-1">
                            <div 
                              class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
                              :class="{
                                'border-blue-500 bg-blue-500': form.communicationStyle === style.value,
                                'border-gray-400 bg-white': form.communicationStyle !== style.value
                              }"
                            >
                              <font-awesome-icon 
                                v-if="form.communicationStyle === style.value"
                                :icon="['fas', 'fa-check']" 
                                class="w-3 h-3 text-white" 
                              />
                            </div>
                          </div>
                          <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                              <h4 class="font-semibold text-lg text-gray-900">{{ style.title }}</h4>
                              <Badge 
                                v-if="form.communicationStyle === style.value"
                                value="Selected" 
                                severity="success" 
                                class="text-xs"
                              />
                            </div>
                            <p class="text-gray-600 mb-3">{{ style.description }}</p>
                            <div 
                              class="p-4 rounded-lg border"
                              :class="{
                                'bg-blue-100 border-blue-200': form.communicationStyle === style.value,
                                'bg-white border-gray-200': form.communicationStyle !== style.value
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

                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Custom Greeting (Optional)
                  </label>
                  <Input
                    v-model="form.customGreeting"
                    placeholder="e.g., Thanks for choosing Miller Electrical!"
                    class="w-full"
                  />
                </div>
              </div>

              <!-- Step 4: Payment -->
              <div v-if="currentStep === 3" class="space-y-6">
                <div class="text-center mb-8">
                  <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <font-awesome-icon :icon="['fas', 'fa-credit-card']" class="w-8 h-8 text-white" />
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 mb-2">Complete your subscription</h3>
                  <p class="text-gray-600">Start your 14-day free trial today</p>
                </div>

                <Card class="border-2 border-blue-500 bg-blue-50">
                  <template #content>
                    <div class="p-6 text-center">
                      <Badge 
                        :value="selectedPlan === 'professional' ? 'Most Popular' : 'Selected Plan'"
                        :severity="selectedPlan === 'professional' ? 'success' : 'info'" 
                        class="mb-3" 
                      />
                      <h4 class="text-2xl font-bold text-gray-900 capitalize mb-2">
                        {{ selectedPlan }} Plan
                      </h4>
                      <div class="text-4xl font-black text-blue-600 mb-4">
                        ${{ planPricing[selectedPlan]?.price }}
                        <span class="text-lg font-normal">/month</span>
                      </div>
                      <div class="space-y-2 text-sm text-gray-700">
                        <div 
                          v-for="(feature, index) in planPricing[selectedPlan]?.features" 
                          :key="index"
                          class="flex items-center justify-center"
                        >
                          <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="w-4 h-4 text-green-600 mr-2" />
                          {{ feature }}
                        </div>
                      </div>
                    </div>
                  </template>
                </Card>

                <div class="bg-gray-50 p-6 rounded-xl text-center">
                  <div class="flex items-center justify-center text-gray-600">
                    <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="w-5 h-5 text-green-600 mr-2" />
                    <span>14-day free trial • No setup fees • Cancel anytime</span>
                  </div>
                </div>
              </div>

              <!-- Step 5: Phone Setup -->
              <div v-if="currentStep === 4" class="space-y-6">
                <div class="text-center mb-8">
                  <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <font-awesome-icon :icon="['fas', 'fa-phone']" class="w-8 h-8 text-white" />
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 mb-2">Your Australian SMS number</h3>
                  <p class="text-gray-600">We're setting up your dedicated business line</p>
                </div>

                <div class="text-center">
                  <Card class="border-2 border-green-500 bg-green-50 inline-block">
                    <template #content>
                      <div class="p-6">
                        <h4 class="font-semibold text-gray-900 mb-2">Your New Number</h4>
                        <div class="text-2xl font-bold text-green-600 mb-3">
                          +61 2 8123 4567
                        </div>
                        <p class="text-sm text-gray-600">Ready to receive SMS quotes!</p>
                      </div>
                    </template>
                  </Card>
                </div>

                <div class="bg-blue-50 p-6 rounded-xl">
                  <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                    <font-awesome-icon :icon="['fas', 'fa-star']" class="w-5 h-5 text-yellow-500 mr-2" />
                    What happens next?
                  </h4>
                  <div class="space-y-3 text-sm text-gray-700">
                    <div class="flex items-center">
                      <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="w-4 h-4 text-green-600 mr-3" />
                      Your AI assistant is trained and ready
                    </div>
                    <div class="flex items-center">
                      <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="w-4 h-4 text-green-600 mr-3" />
                      SMS forwarding is automatically configured
                    </div>
                    <div class="flex items-center">
                      <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="w-4 h-4 text-green-600 mr-3" />
                      Start receiving and responding to leads instantly
                    </div>
                  </div>
                </div>
              </div>

              <!-- Navigation -->
              <div class="flex justify-between pt-8 border-t">
                <Button
                  type="button"
                  outlined
                  @click="prevStep"
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
                  :label="form.processing ? 'Setting up...' : currentStep === steps.length - 1 ? 'Complete Setup' : 'Continue'"
                />
              </div>
            </form>
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>