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
      <div
        class="absolute top-10 sm:top-20 left-10 sm:left-20 w-48 sm:w-72 h-48 sm:h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse"
      ></div>
      <div
        class="absolute top-20 sm:top-40 right-10 sm:right-20 w-48 sm:w-72 h-48 sm:h-72 bg-green-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-75"
      ></div>
      <div
        class="absolute -bottom-4 sm:-bottom-8 left-20 sm:left-40 w-48 sm:w-72 h-48 sm:h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-150"
      ></div>
    </div>

    <div class="container mx-auto px-4 py-6 sm:py-12 max-w-5xl relative z-10">
      <!-- Header -->
      <div class="text-center mb-6 sm:mb-12">
        <!-- Logo -->
        <div class="flex flex-col items-center justify-center mb-4 sm:mb-8">
          <div class="relative mb-2 sm:mb-0">
            <div class="bg-white p-2 sm:p-4 rounded-2xl shadow-2xl">
              <img
                src="/images/logo.png"
                alt="PingMate"
                class="rounded-lg h-16 w-16 sm:h-24 sm:w-24 transform scale-110 sm:scale-120"
              />
            </div>
            <div
              class="absolute -top-1 sm:-top-2 -right-1 sm:-right-2 w-3 h-3 sm:w-6 sm:h-6 bg-green-400 rounded-full animate-ping"
            ></div>
            <div
              class="absolute -top-1 sm:-top-2 -right-1 sm:-right-2 w-3 h-3 sm:w-6 sm:h-6 bg-green-400 rounded-full"
            ></div>
          </div>
        </div>

        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white mb-2 sm:mb-6 leading-tight px-2">
          Ready to Win More Jobs?
        </h2>
        <p class="text-base sm:text-xl text-blue-100 mb-4 sm:mb-8 max-w-2xl mx-auto leading-relaxed px-2">
          Tell us about your business and we'll set up your AI assistant to start capturing leads instantly
        </p>
      </div>

      <!-- Main Form Card -->
      <div
        class="bg-white/95 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-2xl border border-white/20 overflow-hidden transform transition-all duration-700 mx-1 sm:mx-0"
        :class="{ 'translate-y-0 opacity-100 scale-100': isLoaded, 'translate-y-10 opacity-0 scale-95': !isLoaded }"
      >
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-blue-50 to-green-50 p-4 sm:p-8 border-b border-gray-100">
          <div class="text-center">
            <div
              class="inline-flex items-center justify-center w-10 h-10 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500 to-green-500 rounded-2xl mb-2 sm:mb-4 shadow-lg"
            >
              <font-awesome-icon :icon="['fas', 'user-tie']" class="text-white text-sm sm:text-2xl" />
            </div>
            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">Tell Us About Your Business</h3>
            <p class="text-gray-600 max-w-md mx-auto text-sm sm:text-base px-2 sm:px-0">
              We'll customise your AI assistant to match your trade, pricing, and communication style
            </p>
          </div>
        </div>

        <!-- Form Content -->
        <div class="p-4 sm:p-8 lg:p-10">
          <form @submit.prevent="onSubmit" class="space-y-4 sm:space-y-8">
            <!-- Personal & Business Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-6">
              <!-- First Name -->
              <div class="space-y-1 sm:space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                  Your First Name
                  <span class="text-red-500">*</span>
                </label>
                <Input
                  v-model="form.user.first_name"
                  placeholder="e.g., Dave"
                  class="w-full py-2.5 sm:py-3 px-3 sm:px-4 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
                  required
                  :class="{ '!border-red-300 !ring-red-100': form.errors['user.first_name'] }"
                />
                <div v-if="form.errors['user.first_name']" class="text-red-500 text-sm flex items-center">
                  <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="mr-1" />
                  {{ form.errors['user.first_name'] }}
                </div>
              </div>

              <!-- Business Name -->
              <div class="space-y-1 sm:space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                  Business Name
                  <span class="text-red-500">*</span>
                </label>
                <Input
                  v-model="form.settings.business_name"
                  placeholder="e.g., Dave's Electric"
                  class="w-full py-2.5 sm:py-3 px-3 sm:px-4 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
                  required
                  :class="{ '!border-red-300 !ring-red-100': form.errors['settings.business_name'] }"
                />
                <div v-if="form.errors['settings.business_name']" class="text-red-500 text-sm flex items-center">
                  <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="mr-1" />
                  {{ form.errors['settings.business_name'] }}
                </div>
              </div>

              <!-- Email -->
              <div class="space-y-1 sm:space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                  Email Address
                  <span class="text-red-500">*</span>
                </label>
                <Input
                  v-model="form.user.email"
                  type="email"
                  placeholder="e.g., dave@daveelectric.com.au"
                  class="w-full py-2.5 sm:py-3 px-3 sm:px-4 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
                  required
                  :class="{ '!border-red-300 !ring-red-100': form.errors['user.email'] }"
                />
                <div v-if="form.errors['user.email']" class="text-red-500 text-sm flex items-center">
                  <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="mr-1" />
                  {{ form.errors['user.email'] }}
                </div>
              </div>

              <!-- Industry Type -->
              <div class="space-y-1 sm:space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                  Your Industry
                  <span class="text-red-500">*</span>
                </label>
                <Select
                  v-model="form.settings.industry_type"
                  :options="industryTypes"
                  optionLabel="label"
                  optionValue="value"
                  placeholder="Select your industry"
                  class="w-full text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
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
            <div class="space-y-1 sm:space-y-2">
              <label class="block text-sm font-bold text-gray-700">
                Mobile Number
                <span class="text-red-500">*</span>
              </label>
              <Input
                v-model="form.user.mobile"
                type="tel"
                placeholder="e.g., 0412 345 678"
                class="w-full py-2.5 sm:py-3 px-3 sm:px-4 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors"
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
            <div
              class="bg-gradient-to-br from-blue-50 to-green-50 border-2 border-blue-200 rounded-2xl p-3 sm:p-6 relative overflow-hidden"
            >
              <!-- Background decoration -->
              <div
                class="absolute top-0 right-0 w-16 sm:w-32 h-16 sm:h-32 bg-blue-200/20 rounded-full -mr-8 sm:-mr-16 -mt-8 sm:-mt-16"
              ></div>
              <div
                class="absolute bottom-0 left-0 w-12 sm:w-24 h-12 sm:h-24 bg-green-200/20 rounded-full -ml-6 sm:-ml-12 -mb-6 sm:-mb-12"
              ></div>

              <div class="relative z-10">
                <div class="flex items-center mb-3 sm:mb-4">
                  <font-awesome-icon
                    :icon="['fas', 'rocket']"
                    class="text-blue-600 text-lg sm:text-xl mr-3 sm:mr-4 flex-shrink-0"
                  />
                  <h4 class="text-base sm:text-xl font-bold text-gray-900">What Happens After Payment?</h4>
                </div>

                <p class="text-gray-700 text-sm sm:text-lg leading-relaxed">
                  You will get an email with your Aussie number and login details. From there, just follow our 5‑minute
                  guide to customise your AI and start landing jobs — fast.
                </p>
              </div>
            </div>

            <!-- Submit Button -->
            <Button
              type="submit"
              :disabled="form.processing"
              class="w-full !bg-gradient-to-r !from-blue-600 !to-green-600 hover:!from-blue-700 hover:!to-green-700 !py-3.5 sm:!py-4 !text-base sm:!text-xl !font-bold shadow-2xl transform hover:scale-105 transition-all duration-200 cursor-pointer"
              :icon="form.processing ? ['fas', 'spinner'] : ['fas', 'rocket']"
              :label="form.processing ? 'Setting up your account...' : 'Start Winning Jobs – $29.90/month'"
            />

            <!-- Risk Reduction Badge -->
            <div class="text-center">
              <div
                class="inline-flex items-center bg-gray-50 rounded-lg px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-gray-600"
              >
                Billed monthly. Cancel anytime, no contracts.
              </div>
            </div>

            <!-- Trust Indicators -->
            <div
              class="flex flex-wrap justify-center items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-600 pt-1 sm:pt-4"
            >
              <div class="flex items-center gap-1.5 sm:gap-2">
                <span>📞</span>
                <span class="font-medium">Local Aussie number</span>
              </div>
              <div class="hidden sm:block text-gray-400">|</div>
              <div class="flex items-center gap-1.5 sm:gap-2">
                <span>🔐</span>
                <span class="font-medium">Secure payment</span>
              </div>
              <div class="hidden sm:block text-gray-400">|</div>
              <div class="flex items-center gap-1.5 sm:gap-2">
                <span>🔄</span>
                <span class="font-medium">Cancel anytime</span>
              </div>
              <div class="hidden sm:block text-gray-400">|</div>
              <div class="flex items-center gap-1.5 sm:gap-2">
                <span>💰</span>
                <span class="font-medium">30‑day guarantee</span>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Bottom Trust Section -->
      <div class="mt-6 sm:mt-12 text-center px-2">
        <div
          class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-8 bg-white/10 backdrop-blur-sm rounded-2xl px-3 sm:px-8 py-3 sm:py-4 border border-white/20 max-w-5xl mx-auto"
        >
          <div class="flex items-center gap-2 text-blue-200">
            <font-awesome-icon :icon="['fas', 'clock']" class="flex-shrink-0 text-xs sm:text-sm" />
            <span class="text-xs sm:text-sm font-medium">Setup in under 5 minutes</span>
          </div>
          <div class="flex items-center gap-2 text-blue-200">
            <font-awesome-icon :icon="['fas', 'shield-alt']" class="flex-shrink-0 text-xs sm:text-sm" />
            <span class="text-xs sm:text-sm font-medium">30-day money back guarantee</span>
          </div>
          <div class="flex items-center gap-2 text-blue-200">
            <span class="text-xs sm:text-sm font-medium">🇦🇺 Australian owned & operated</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
