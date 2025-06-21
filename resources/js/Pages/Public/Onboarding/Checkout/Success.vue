<script setup>
import { router } from '@inertiajs/vue3';
import Public from '@/Layouts/Public.vue';
import Button from '@/Shared/Ui/Button/Button.vue';

defineOptions({
  layout: Public,
});

const props = defineProps({
  planType: String,
  businessName: String,
  firstName: String,
  phoneNumber: String,
});

const setupPricing = () => {
  router.visit(route('dashboard'));
};
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex items-center justify-center mb-6">
          <div class="w-20 h-20 bg-green-500 rounded-full shadow-lg animate-pulse flex items-center justify-center">
            <font-awesome-icon :icon="['fas', 'fa-check']" class="text-white text-2xl" />
          </div>
        </div>
        <h1 class="text-4xl font-black text-white mb-4">🎉 Welcome to PingMate, {{ firstName }}!</h1>
        <p class="text-xl text-green-100 mb-2">Payment successful – Your AI assistant is ready to win you more jobs</p>
      </div>

      <!-- Success Card -->
      <div class="bg-white/95 backdrop-blur rounded-2xl shadow-2xl p-8 mb-8">
        <!-- Phone Number Section -->
        <div class="text-center mb-8">
          <div
            class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg"
          >
            <font-awesome-icon :icon="['fas', 'fa-phone']" class="w-8 h-8 text-white" />
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Your Australian SMS Number is Live!</h3>
          <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6 mb-6">
            <div class="text-3xl font-bold text-green-600 mb-2">
              {{ phoneNumber || '+61 2 8123 4567' }}
            </div>
            <p class="text-gray-600">This number is now live and ready to auto-reply with your custom quotes.</p>
          </div>
        </div>

        <!-- What's included -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-blue-50 p-6 rounded-xl text-center">
            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
              <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-white" />
            </div>
            <h4 class="font-bold text-gray-900 mb-2">AI Assistant</h4>
            <p class="text-gray-600 text-sm">Responds instantly to SMS with professional quotes</p>
          </div>
          <div class="bg-green-50 p-6 rounded-xl text-center">
            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
              <font-awesome-icon :icon="['fas', 'fa-phone-alt']" class="text-white" />
            </div>
            <h4 class="font-bold text-gray-900 mb-2">Call Summaries</h4>
            <p class="text-gray-600 text-sm">Voicemails transcribed and summarized for you</p>
          </div>
          <div class="bg-purple-50 p-6 rounded-xl text-center">
            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
              <font-awesome-icon :icon="['fas', 'fa-chart-line']" class="text-white" />
            </div>
            <h4 class="font-bold text-gray-900 mb-2">Lead Dashboard</h4>
            <p class="text-gray-600 text-sm">Track all conversations and manage quotes</p>
          </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-xl p-6 border border-blue-200 mb-6">
          <h4 class="font-bold text-gray-900 mb-4 flex items-center">
            <font-awesome-icon :icon="['fas', 'fa-rocket']" class="text-blue-600 mr-2" />
            Complete Your Setup (2 minutes)
          </h4>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div class="flex items-start gap-3">
              <div
                class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5"
              >
                1
              </div>
              <div>
                <p class="font-medium text-gray-900">Set Your Pricing</p>
                <p class="text-gray-600">Configure your callout fee and hourly rates</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <div
                class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5"
              >
                2
              </div>
              <div>
                <p class="font-medium text-gray-900">Choose AI Voice</p>
                <p class="text-gray-600">Pick casual or professional tone for responses</p>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="text-center">
          <Button
            @click="setupPricing"
            class="!bg-gradient-to-r !from-blue-600 !to-green-600 hover:!from-blue-700 hover:!to-green-700 !py-4 !px-8 !text-lg !font-bold shadow-xl"
            :icon="['fas', 'fa-cogs']"
            label="Complete Setup & Start Winning Jobs"
          />
        </div>
      </div>

      <!-- Support Section -->
      <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200 text-center">
        <font-awesome-icon :icon="['fas', 'fa-headset']" class="text-purple-600 text-2xl mb-3" />
        <h4 class="font-bold text-purple-900 mb-2">Need help getting started?</h4>
        <p class="text-purple-700 text-sm mb-4">
          Our support team is here to help you make the most of your AI assistant
        </p>
        <Button
          class="!bg-purple-600 hover:!bg-purple-700 !text-white"
          :icon="['fas', 'fa-envelope']"
          label="Contact Support"
        />
      </div>
    </div>
  </div>
</template>
