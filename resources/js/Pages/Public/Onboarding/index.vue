<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import Public from '@/Layouts/Public.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import Input from '@/Shared/Ui/Form/Input.vue';
import Select from '@/Shared/Ui/Form/Select.vue';

defineOptions({
  layout: Public,
});

const { showToast } = useToast();

const isLoaded = ref(false);

const form = useForm({
  user: {
    first_name: '',
    email: '',
    mobile: '',
  },
  settings: {
    business_name: '',
    industry_type: '',
  },
});

const industryTypes = [
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

const onSubmit = () => {
  form.post(route('checkout'), {
    onError: () => {
      showToast('error', 'Setup failed. Please try again.');
    },
  });
};

setTimeout(() => {
  isLoaded.value = true;
}, 100);
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-10 sm:top-20 left-10 sm:left-20 w-48 sm:w-72 h-48 sm:h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
      <div class="absolute top-20 sm:top-40 right-10 sm:right-20 w-48 sm:w-72 h-48 sm:h-72 bg-green-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-75"></div>
      <div class="absolute -bottom-4 sm:-bottom-8 left-20 sm:left-40 w-48 sm:w-72 h-48 sm:h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-150"></div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-12 max-w-5xl relative z-10">
      <!-- Header -->
      <div class="text-center mb-8 sm:mb-12">
        <!-- Logo -->
        <div class="flex flex-col sm:flex-row items-center justify-center mb-6 sm:mb-8">
          <div class="relative mb-4 sm:mb-0">
            <div class="bg-gradient-to-br from-blue-500 to-green-500 p-3 sm:p-4 rounded-2xl shadow-2xl">
              <font-awesome-icon :icon="['fas', 'robot']" class="text-white text-2xl sm:text-3xl" />
            </div>
            <div class="absolute -top-1 sm:-top-2 -right-1 sm:-right-2 w-4 h-4 sm:w-6 sm:h-6 bg-green-400 rounded-full animate-ping"></div>
            <div class="absolute -top-1 sm:-top-2 -right-1 sm:-right-2 w-4 h-4 sm:w-6 sm:h-6 bg-green-400 rounded-full"></div>
          </div>
          <div class="sm:ml-4 text-center sm:text-left">
            <h1 class="text-3xl sm:text-4xl font-black text-white">PingMate</h1>
            <p class="text-blue-200 text-sm">AI Assistant</p>
          </div>
        </div>

        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-4 sm:mb-6 leading-tight px-4">
          Ready to Win More Jobs?
        </h2>
        <p class="text-lg sm:text-xl text-blue-100 mb-6 sm:mb-8 max-w-2xl mx-auto leading-relaxed px-4">
          Tell us about your business and we'll set up your AI assistant to start capturing leads instantly
        </p>
      </div>

      <!-- Main Form Card -->
      <div
        class="bg-white/95 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-2xl border border-white/20 overflow-hidden transform transition-all duration-700 mx-2 sm:mx-0"
        :class="{ 'translate-y-0 opacity-100 scale-100': isLoaded, 'translate-y-10 opacity-0 scale-95': !isLoaded }"
      >
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-blue-50 to-green-50 p-6 sm:p-8 border-b border-gray-100">
          <div class="text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500 to-green-500 rounded-2xl mb-3 sm:mb-4 shadow-lg">
              <font-awesome-icon :icon="['fas', 'user-tie']" class="text-white text-lg sm:text-2xl" />
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Tell Us About Your Business</h3>
            <p class="text-gray-600 max-w-md mx-auto text-sm sm:text-base px-4 sm:px-0">
              We'll customise your AI assistant to match your trade, pricing, and communication style
            </p>
          </div>
        </div>

        <!-- Form Content -->
        <div class="p-6 sm:p-8 lg:p-10">
          <form @submit.prevent="onSubmit" class="space-y-6 sm:space-y-8">
            <!-- Personal & Business Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
              <!-- First Name -->
              <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                  Your First Name <span class="text-red-500">*</span>
                </label>
                <Input
                  v-model="form.user.first_name"
                  placeholder="e.g., Dave"
                  class="w-full py-3 px-4 text-base sm:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
                  required
                  :class="{ '!border-red-300 !ring-red-100': form.errors['user.first_name'] }"
                />
                <div v-if="form.errors['user.first_name']" class="text-red-500 text-sm flex items-center">
                  <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="mr-1" />
                  {{ form.errors['user.first_name'] }}
                </div>
              </div>

              <!-- Business Name -->
              <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                  Business Name <span class="text-red-500">*</span>
                </label>
                <Input
                  v-model="form.settings.business_name"
                  placeholder="e.g., Dave's Electric"
                  class="w-full py-3 px-4 text-base sm:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
                  required
                  :class="{ '!border-red-300 !ring-red-100': form.errors['settings.business_name'] }"
                />
                <div v-if="form.errors['settings.business_name']" class="text-red-500 text-sm flex items-center">
                  <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="mr-1" />
                  {{ form.errors['settings.business_name'] }}
                </div>
              </div>

              <!-- Email -->
              <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                  Email Address <span class="text-red-500">*</span>
                </label>
                <Input
                  v-model="form.user.email"
                  type="email"
                  placeholder="e.g., dave@daveelectric.com.au"
                  class="w-full py-3 px-4 text-base sm:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
                  required
                  :class="{ '!border-red-300 !ring-red-100': form.errors['user.email'] }"
                />
                <div v-if="form.errors['user.email']" class="text-red-500 text-sm flex items-center">
                  <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="mr-1" />
                  {{ form.errors['user.email'] }}
                </div>
              </div>

              <!-- Industry Type -->
              <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                  Your Industry <span class="text-red-500">*</span>
                </label>
                <Select
                  v-model="form.settings.industry_type"
                  :options="industryTypes"
                  optionLabel="label"
                  optionValue="value"
                  placeholder="Select your industry"
                  class="w-full text-base sm:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
                  required
                  :class="{ '!border-red-300 !ring-red-100': form.errors['settings.industry_type'] }"
                />
                <div v-if="form.errors['settings.industry_type']" class="text-red-500 text-sm flex items-center">
                  <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="mr-1" />
                  {{ form.errors['settings.industry_type'] }}
                </div>
              </div>
            </div>

            <!-- Mobile Number - Full Width -->
            <div class="space-y-2">
              <label class="block text-sm font-bold text-gray-700">
                Mobile Number <span class="text-red-500">*</span>
              </label>
              <Input
                v-model="form.user.mobile"
                type="tel"
                placeholder="e.g., 0412 345 678"
                class="w-full py-3 px-4 text-base sm:text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
                required
                :class="{ '!border-red-300 !ring-red-100': form.errors['user.mobile'] }"
              />
              <p class="text-gray-500 text-sm flex items-center">
                <font-awesome-icon :icon="['fas', 'info-circle']" class="mr-2 text-blue-500 flex-shrink-0" />
                We'll forward important leads to this number
              </p>
              <div v-if="form.errors['user.mobile']" class="text-red-500 text-sm flex items-center">
                <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="mr-1" />
                {{ form.errors['user.mobile'] }}
              </div>
            </div>

            <!-- What Happens Next -->
            <div class="bg-gradient-to-br from-blue-50 to-green-50 border-2 border-blue-200 rounded-2xl p-4 sm:p-6 relative overflow-hidden">
              <!-- Background decoration -->
              <div class="absolute top-0 right-0 w-20 sm:w-32 h-20 sm:h-32 bg-blue-200/20 rounded-full -mr-10 sm:-mr-16 -mt-10 sm:-mt-16"></div>
              <div class="absolute bottom-0 left-0 w-16 sm:w-24 h-16 sm:h-24 bg-green-200/20 rounded-full -ml-8 sm:-ml-12 -mb-8 sm:-mb-12"></div>
              
              <div class="relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-center mb-4">
                  <div class="bg-gradient-to-br from-blue-500 to-green-500 rounded-2xl p-2 sm:p-3 mr-0 sm:mr-4 mb-3 sm:mb-0 w-fit">
                    <font-awesome-icon :icon="['fas', 'rocket']" class="text-white text-lg sm:text-xl" />
                  </div>
                  <h4 class="text-lg sm:text-xl font-bold text-gray-900">What happens next?</h4>
                </div>
                
                <p class="text-gray-700 mb-4 sm:mb-6 text-base sm:text-lg leading-relaxed">
                  After payment, we'll instantly email you your new Australian phone number, secure password, 
                  and a quick 5-minute tutorial to get your AI assistant working immediately.
                </p>
                
                <!-- Timeline steps -->
                <div class="space-y-3">
                  <div class="flex items-center bg-white/70 rounded-lg p-3 shadow-sm">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                      <span class="text-white font-bold text-xs sm:text-sm">1</span>
                    </div>
                    <span class="text-gray-800 font-medium text-sm sm:text-base">Email with your Aussie number & login details</span>
                  </div>
                  <div class="flex items-center bg-white/70 rounded-lg p-3 shadow-sm">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                      <span class="text-white font-bold text-xs sm:text-sm">2</span>
                    </div>
                    <span class="text-gray-800 font-medium text-sm sm:text-base">Follow 5-minute setup guide</span>
                  </div>
                  <div class="flex items-center bg-white/70 rounded-lg p-3 shadow-sm">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                      <span class="text-white font-bold text-xs sm:text-sm">3</span>
                    </div>
                    <span class="text-gray-800 font-medium text-sm sm:text-base">Start winning jobs instantly</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Submit Button -->
            <Button
              type="submit"
              :disabled="form.processing"
              class="w-full !bg-gradient-to-r !from-blue-600 !to-green-600 hover:!from-blue-700 hover:!to-green-700 !py-4 !text-lg sm:!text-xl !font-bold shadow-2xl transform hover:scale-105 transition-all duration-200 cursor-pointer"
              :icon="form.processing ? ['fas', 'spinner'] : ['fas', 'credit-card']"
              :label="form.processing ? 'Setting up your account...' : 'Continue to Payment → $39.90/month'"
            />

            <!-- Trust Indicators -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 pt-2 sm:pt-4">
              <div class="flex flex-col items-center text-center bg-white rounded-xl p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                  <font-awesome-icon :icon="['fas', 'phone']" class="text-blue-600 text-sm sm:text-base" />
                </div>
                <span class="text-xs sm:text-sm font-medium text-gray-700">Local number included</span>
              </div>
              
              <div class="flex flex-col items-center text-center bg-white rounded-xl p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                  <font-awesome-icon :icon="['fas', 'shield-alt']" class="text-green-600 text-sm sm:text-base" />
                </div>
                <span class="text-xs sm:text-sm font-medium text-gray-700">SSL secure payment</span>
              </div>
              
              <div class="flex flex-col items-center text-center bg-white rounded-xl p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                  <font-awesome-icon :icon="['fas', 'times-circle']" class="text-purple-600 text-sm sm:text-base" />
                </div>
                <span class="text-xs sm:text-sm font-medium text-gray-700">Cancel anytime</span>
              </div>
              
              <div class="flex flex-col items-center text-center bg-white rounded-xl p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                  <font-awesome-icon :icon="['fas', 'money-bill-wave']" class="text-green-600 text-sm sm:text-base" />
                </div>
                <span class="text-xs sm:text-sm font-medium text-gray-700">30-day guarantee</span>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Bottom Trust Section -->
      <div class="mt-8 sm:mt-12 text-center px-4">
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-8 bg-white/10 backdrop-blur-sm rounded-2xl px-4 sm:px-8 py-4 border border-white/20 max-w-4xl mx-auto">
          <div class="flex items-center gap-2 text-blue-200">
            <font-awesome-icon :icon="['fas', 'clock']" class="flex-shrink-0" />
            <span class="text-sm font-medium">Setup in under 5 minutes</span>
          </div>
          <div class="flex items-center gap-2 text-blue-200">
            <font-awesome-icon :icon="['fas', 'shield-alt']" class="flex-shrink-0" />
            <span class="text-sm font-medium">30-day money back guarantee</span>
          </div>
          <div class="flex items-center gap-2 text-blue-200">
            <span class="text-sm font-medium">🇦🇺 Australian owned & operated</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>