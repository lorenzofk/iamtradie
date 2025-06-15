<script setup>
import Card from 'primevue/card';

const { planType, businessName } = defineProps({
  planType: String,
  businessName: String,
});

const planFeatures = {
  starter: {
    price: 39.9,
    features: [
      '500 AI-powered quote replies/month',
      'Dedicated Australian SMS number',
      'Embedded website quote form',
      'Custom callout + hourly pricing setup',
      'Lead dashboard + response tracking',
      'Choose your AI voice: casual or professional',
    ],
  },
};

const formatPrice = price => {
  return price.toFixed(2);
};
</script>

<template>
  <Card class="shadow-2xl border-0 bg-white/95 backdrop-blur overflow-hidden">
    <template #content>
      <div class="relative">
        <!-- Header with gradient background -->
        <div class="bg-gradient-to-r from-blue-600 to-green-600 p-8 text-white text-center rounded-lg">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
            <font-awesome-icon :icon="['fas', 'fa-crown']" class="text-white text-xl" />
          </div>
          <h3 class="text-3xl font-bold mb-2 capitalize">{{ planType }} Plan</h3>
          <div class="text-2xl font-bold">${{ formatPrice(planFeatures[planType]?.price) }}/month</div>
          <p class="text-blue-100 mt-2">Your AI-powered quote assistant is ready</p>

          <!-- Account details in header -->
          <div class="mt-6 pt-4 border-t border-white/20">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
              <div>
                <div class="text-blue-200 text-xs uppercase tracking-wide">Business</div>
                <div class="font-semibold">{{ businessName }}</div>
              </div>
              <div>
                <div class="text-blue-200 text-xs uppercase tracking-wide">Plan Type</div>
                <div class="font-semibold capitalize">{{ planType }}</div>
              </div>
              <div>
                <div class="text-blue-200 text-xs uppercase tracking-wide">Billing</div>
                <div class="font-semibold">Monthly</div>
              </div>
              <div>
                <div class="text-blue-200 text-xs uppercase tracking-wide">Next Charge</div>
                <div class="font-semibold">
                  {{ new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toLocaleDateString() }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Content area -->
        <div class="p-8">
          <!-- Features in clean grid -->
          <div class="mb-8">
            <h4 class="text-lg font-bold text-gray-900 mb-6 text-center">Everything you get with {{ planType }}</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div
                v-for="feature in planFeatures[planType]?.features"
                :key="feature"
                class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
              >
                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4">
                  <font-awesome-icon :icon="['fas', 'fa-check']" class="text-white text-sm" />
                </div>
                <span class="text-gray-800 font-medium text-sm">{{ feature }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </Card>
</template>
