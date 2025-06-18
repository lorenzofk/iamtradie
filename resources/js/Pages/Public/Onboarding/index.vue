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
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex items-center justify-center mb-6">
          <div class="bg-gradient-to-r from-blue-600 to-green-600 p-3 rounded-xl mr-4 shadow-lg">
            <font-awesome-icon :icon="['fas', 'fa-rocket']" class="text-white text-2xl" />
          </div>
          <h1 class="text-3xl font-bold text-white">PingMate</h1>
        </div>
        <h2 class="text-4xl font-black text-white mb-4">Start Your AI Assistant</h2>
        <p class="text-xl text-blue-100 mb-6">Just a few details and you'll be winning more jobs in minutes</p>
        
        <!-- Trust indicators -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-8 text-blue-200 text-sm mb-8">
          <div class="flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'shield-alt']" />
            <span>30-day money back guarantee</span>
          </div>
          <div class="flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'clock']" />
            <span>Setup in under 2 minutes</span>
          </div>
          <div class="flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'flag']" />
            <span>🇦🇺 Australian owned</span>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div
        class="bg-white/95 backdrop-blur rounded-2xl shadow-2xl p-8 transform transition-all duration-500"
        :class="{ 'translate-y-0 opacity-100': isLoaded, 'translate-y-10 opacity-0': !isLoaded }"
      >
        <div class="text-center mb-8">
          <div
            class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg"
          >
            <font-awesome-icon :icon="['fas', 'fa-user-tie']" class="w-8 h-8 text-white" />
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-2">Tell us about your business</h3>
          <p class="text-gray-600">We'll use this to create your AI assistant and generate personalized quotes</p>
        </div>

        <form @submit.prevent="onSubmit" class="space-y-6">
          <!-- Form Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- First Name -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Your First Name <span class="text-red-500">*</span>
              </label>
              <Input
                v-model="form.user.first_name"
                placeholder="e.g., Dave"
                class="w-full"
                required
                :class="{ 'border-red-300': form.errors['user.first_name'] }"
              />
              <div v-if="form.errors['user.first_name']" class="text-red-500 text-sm mt-1">
                {{ form.errors['user.first_name'] }}
              </div>
            </div>

            <!-- Business Name -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Business Name <span class="text-red-500">*</span>
              </label>
              <Input
                v-model="form.settings.business_name"
                placeholder="e.g., Dave's Electric"
                class="w-full"
                required
                :class="{ 'border-red-300': form.errors['settings.business_name'] }"
              />
              <div v-if="form.errors['settings.business_name']" class="text-red-500 text-sm mt-1">
                {{ form.errors['settings.business_name'] }}
              </div>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Email Address <span class="text-red-500">*</span>
              </label>
              <Input
                v-model="form.user.email"
                type="email"
                placeholder="e.g., dave@daveelectric.com.au"
                class="w-full"
                required
                :class="{ 'border-red-300': form.errors['user.email'] }"
              />
              <div v-if="form.errors['user.email']" class="text-red-500 text-sm mt-1">
                {{ form.errors['user.email'] }}
              </div>
            </div>

            <!-- Trade Type -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Your Trade <span class="text-red-500">*</span>
              </label>
              <Select
                v-model="form.settings.industry_type"
                :options="tradeTypes"
                optionLabel="label"
                optionValue="value"
                placeholder="Select your trade"
                class="w-full"
                required
                :class="{ 'border-red-300': form.errors['settings.industry_type'] }"
              />
              <div v-if="form.errors['settings.industry_type']" class="text-red-500 text-sm mt-1">
                {{ form.errors['settings.industry_type'] }}
              </div>
            </div>
          </div>

          <!-- Mobile Number -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Mobile Number <span class="text-red-500">*</span>
            </label>
            <Input
              v-model="form.user.mobile"
              type="tel"
              placeholder="e.g., 0412 345 678"
              class="w-full"
              required
              :class="{ 'border-red-300': form.errors['user.mobile'] }"
            />
            <p class="text-gray-500 text-sm mt-1">
              We'll forward important leads here and use this for login verification
            </p>
            <div v-if="form.errors['user.mobile']" class="text-red-500 text-sm mt-1">
              {{ form.errors['user.mobile'] }}
            </div>
          </div>

          <!-- Simple reassurance line -->
          <div class="text-center py-2">
            <p class="text-gray-600 text-sm">
              You're nearly there — just confirm payment and we'll set up your Aussie number + AI assistant instantly.
            </p>
            <p class="text-gray-500 text-xs mt-1">
              You'll be able to customise your pricing, tone, and replies right after signup.
            </p>
          </div>

          <!-- Submit Button -->
          <Button
            type="submit"
            :disabled="form.processing"
            class="w-full !bg-gradient-to-r !from-blue-600 !to-green-600 hover:!from-blue-700 hover:!to-green-700 !py-4 !text-lg !font-bold shadow-xl"
            :icon="form.processing ? ['fas', 'fa-spinner'] : ['fas', 'fa-rocket']"
            :label="form.processing ? 'Processing...' : 'Start My Free Trial — $29/month after 30 days'"
          />

          <!-- Trust indicators -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center pt-2">
            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
              <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-green-600 text-xs" />
              <span>Local number included</span>
            </div>
            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
              <font-awesome-icon :icon="['fas', 'fa-lock']" class="text-blue-600 text-xs" />
              <span>SSL secure payment</span>
            </div>
            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
              <font-awesome-icon :icon="['fas', 'fa-undo']" class="text-purple-600 text-xs" />
              <span>Cancel anytime</span>
            </div>
            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
              <font-awesome-icon :icon="['fas', 'fa-money-bill-wave']" class="text-green-600 text-xs" />
              <span>30-day guarantee</span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
