<script setup>
import { router } from '@inertiajs/vue3';
import Button from '@/Shared/Ui/Button/Button.vue';

const visit = url => {
  router.visit(url);
};

const features = [
  {
    category: 'Smart Communication',
    items: [
      {
        icon: ['fas', 'comment-dots'],
        text: 'Instant AI SMS replies',
        detail: 'Professional quotes in your voice, 24/7',
      },
      {
        icon: ['fas', 'phone-volume'],
        text: 'Smart call handling',
        detail: 'Forward calls + intelligent voicemail summaries',
      },
      { icon: ['fas', 'map-marker-alt'], text: 'Local Aussie number', detail: 'Customers see a local business number' },
    ],
  },
  {
    category: 'Business Tools',
    items: [
      {
        icon: ['fas', 'calculator'],
        text: 'Your custom pricing',
        detail: 'AI uses your real rates for accurate quotes',
      },
      {
        icon: ['fas', 'chart-line'],
        text: 'Professional dashboard',
        detail: 'Manage quotes, calls, and customer interactions',
      },
      { icon: ['fas', 'mobile-alt'], text: 'Lead forwarding', detail: 'Important messages forwarded to your mobile' },
    ],
  },
  {
    category: 'AI Intelligence',
    items: [
      { icon: ['fas', 'robot'], text: 'Sounds like you', detail: 'AI learns your tone and communication style' },
      { icon: ['fas', 'brain'], text: 'Smart transcription', detail: 'Voice messages converted to text summaries' },
      { icon: ['fas', 'bolt-lightning'], text: 'Instant responses', detail: 'Reply in seconds, even when unavailable' },
    ],
  },
];

const guarantees = [
  { icon: ['fas', 'piggy-bank'], text: '30-day money back guarantee' },
  { icon: ['fas', 'times-circle'], text: 'Cancel anytime, no contracts' },
  { icon: ['fas', 'headset'], text: 'Australian support included' },
];
</script>

<template>
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="text-center mb-12 sm:mb-16">
      <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
        One Simple Plan, Everything Included
      </h2>
      <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto">
        Just $1 a day to never miss another job. No hidden fees, no complicated tiers.
      </p>
    </div>

    <!-- Main Pricing Container -->
    <div class="relative -mx-4 sm:-mx-6 lg:-mx-8">
      <!-- Subtle Popular Badge -->
      <div class="absolute -top-3 sm:-top-4 left-1/2 transform -translate-x-1/2 z-10">
        <div
          class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-4 sm:px-6 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-semibold shadow-lg"
        >
          Most Popular Choice
        </div>
      </div>

      <div
        class="bg-white border-t border-b border-gray-100 sm:border sm:rounded-xl lg:rounded-2xl shadow-xl overflow-hidden mx-4 sm:mx-6 lg:mx-8"
      >
        <!-- Pricing Header -->
        <div class="bg-gradient-to-br from-slate-50 to-blue-50 p-4 sm:p-6 lg:p-8 text-center border-b border-gray-100">
          <div
            class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500 to-green-500 rounded-xl sm:rounded-2xl mb-4 sm:mb-6 shadow-lg"
          >
            <font-awesome-icon :icon="['fas', 'robot']" class="text-white text-lg sm:text-2xl" />
          </div>

          <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">PingMate Complete</h3>

          <div class="flex items-center justify-center mb-3 sm:mb-4">
            <span class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900">$39</span>
            <span class="text-base sm:text-lg lg:text-xl text-gray-600 ml-2">/month</span>
          </div>

          <p class="text-gray-600 text-base sm:text-lg mb-4 sm:mb-6">SMS + Voice AI for busy Australian workers</p>

          <!-- Value Proposition -->
          <div
            class="bg-green-50 border border-green-200 rounded-lg sm:rounded-xl p-3 sm:p-4 max-w-sm sm:max-w-md mx-auto"
          >
            <div class="text-xs sm:text-sm font-semibold text-green-800 mb-1">Win just one extra job per month</div>
            <div class="text-xs sm:text-sm text-green-700">Turn $39 into $500+ → 1,200% ROI</div>
          </div>
        </div>

        <!-- Features Grid -->
        <div class="p-4 sm:p-6 lg:p-8">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-6 sm:mb-8">
            <div v-for="category in features" :key="category.category" class="space-y-3 sm:space-y-4">
              <h4
                class="font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide border-b border-gray-200 pb-2"
              >
                {{ category.category }}
              </h4>
              <div class="space-y-2 sm:space-y-3">
                <div
                  v-for="item in category.items"
                  :key="item.text"
                  class="group flex items-start hover:bg-gray-50 rounded-lg p-2 sm:p-3 -m-2 sm:-m-3 transition-all duration-200"
                >
                  <div
                    class="bg-blue-100 rounded-lg p-1.5 sm:p-2 mr-2 sm:mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0"
                  >
                    <font-awesome-icon :icon="item.icon" class="text-blue-600 text-xs sm:text-sm" />
                  </div>
                  <div class="min-w-0 flex-1">
                    <div class="font-semibold text-gray-900 text-xs sm:text-sm mb-1">{{ item.text }}</div>
                    <div class="text-gray-600 text-xs">{{ item.detail }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Usage Limits -->
          <div class="bg-gray-50 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-6 sm:mb-8">
            <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-center text-sm sm:text-base">
              What's Included Monthly
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 text-center">
              <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm">
                <div class="text-xl sm:text-2xl font-bold text-blue-600 mb-1">100</div>
                <div class="text-xs sm:text-sm text-gray-600">AI SMS Replies</div>
              </div>
              <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm">
                <div class="text-xl sm:text-2xl font-bold text-green-600 mb-1">Unlimited</div>
                <div class="text-xs sm:text-sm text-gray-600">Call Summaries</div>
              </div>
              <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm">
                <div class="text-xl sm:text-2xl font-bold text-purple-600 mb-1">24/7</div>
                <div class="text-xs sm:text-sm text-gray-600">AI Assistant</div>
              </div>
            </div>
          </div>

          <!-- CTA -->
          <div class="text-center mb-4 sm:mb-6">
            <Button
              unstyled
              @click="visit(route('onboarding.show'))"
              class="cursor-pointer inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 text-base sm:text-lg w-full sm:w-auto"
            >
              <font-awesome-icon :icon="['fas', 'rocket']" class="mr-2" />
              Start Your 30-Day Trial
            </Button>
          </div>

          <!-- Setup Promise -->
          <div class="text-center mb-6 sm:mb-8">
            <p class="text-gray-600 font-medium mb-2 text-sm sm:text-base">Ready in under 5 minutes</p>
            <div
              class="flex flex-col sm:flex-row flex-wrap justify-center items-center text-xs sm:text-sm text-gray-500 gap-2 sm:gap-4"
            >
              <span class="flex items-center">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                Enter your rates
              </span>
              <span class="flex items-center">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                Get local number
              </span>
              <span class="flex items-center">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                Start winning jobs
              </span>
            </div>
          </div>

          <!-- Guarantees -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
            <div
              v-for="guarantee in guarantees"
              :key="guarantee.text"
              class="flex items-center justify-center sm:justify-start bg-gray-50 rounded-lg p-3 sm:p-4 hover:bg-gray-100 transition-colors"
            >
              <div class="bg-green-100 rounded-lg p-1.5 sm:p-2 mr-2 sm:mr-3 flex-shrink-0">
                <font-awesome-icon :icon="guarantee.icon" class="text-green-600 text-xs sm:text-sm" />
              </div>
              <span class="text-gray-700 font-medium text-xs sm:text-sm text-center sm:text-left">
                {{ guarantee.text }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Trust Section - Full Width -->
    <div class="mt-12 sm:mt-16 -mx-4 sm:-mx-6 lg:-mx-8">
      <div
        class="bg-green-50 border-t border-b border-green-200 sm:border sm:rounded-2xl p-6 sm:p-8 lg:p-10 mx-4 sm:mx-6 lg:mx-8"
      >
        <div class="max-w-2xl mx-auto text-center">
          <div
            class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-xl sm:rounded-2xl mb-3 sm:mb-4 shadow-lg"
          >
            <font-awesome-icon :icon="['fas', 'fa-shield-alt']" class="text-white text-lg sm:text-2xl" />
          </div>
          <h4 class="text-lg sm:text-xl font-bold text-green-900 mb-2">Risk-Free 30-Day Trial</h4>
          <p class="text-sm sm:text-base text-green-800 leading-relaxed">
            If PingMate doesn't help you win at least one extra job in 30 days, we'll refund every cent. No questions
            asked.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
