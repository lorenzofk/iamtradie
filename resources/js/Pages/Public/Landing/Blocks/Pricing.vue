<script setup>
import { router } from '@inertiajs/vue3';
import Button from '@/Shared/Ui/Button/Button.vue';

const visit = (url) => {
  router.visit(url);
};

const benefits = [
  {
    icon: ['fas', 'fa-phone'],
    text: '1 Australian SMS number (local to your area)',
    highlight: 'Local number'
  },
  {
    icon: ['fas', 'fa-bolt'],
    text: '100 AI-powered SMS replies/month',
    highlight: 'AI replies'
  },
  {
    icon: ['fas', 'fa-dollar-sign'],
    text: 'Use your own pricing – quotes reflect your real rates',
    highlight: 'Your rates'
  },
  {
    icon: ['fas', 'fa-chart-line'],
    text: 'Dashboard to view, edit and send quotes',
    highlight: 'Full dashboard'
  },
  {
    icon: ['fas', 'fa-forward'],
    text: 'Hands-free lead alerts straight to your mobile',
    highlight: 'SMS forwarding'
  },
  {
    icon: ['fas', 'fa-robot'],
    text: 'Your voice tone and style',
    highlight: "AI that sounds just like you"
  },
];

const proofPoints = [
  { icon: ['fas', 'fa-clock'], text: 'Reply instantly, even when you\'re on the tools' },
  { icon: ['fas', 'fa-trophy'], text: 'Secure more jobs without more admin' },
  { icon: ['fas', 'fa-shield-alt'], text: 'Cancel anytime, no lock-in contracts' }
];
</script>

<template>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12 sm:mb-16">
        <h2 class="text-3xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
          Simple Pricing That Pays for Itself
        </h2>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
          Just one missed job can cost you $500. For $1 a day, never let it happen again.
        </p>
      </div>

      <!-- Main Pricing Card -->
      <div class="relative">
        <!-- Popular Badge -->
        <div class="absolute -top-3 sm:-top-4 left-1/2 transform -translate-x-1/2 z-10">
          <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-4 sm:px-6 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg">
            ⭐ Most Popular Plan
          </div>
        </div>
        
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl border-2 border-blue-100 overflow-hidden">
          <!-- Header -->
          <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 sm:p-8 text-center text-white">
            <h3 class="text-xl sm:text-2xl font-bold mb-2">Tradie SMS Plan</h3>
            <div class="flex items-center justify-center mb-2">
              <span class="text-4xl sm:text-5xl font-black">$29.90</span>
              <span class="text-lg sm:text-xl font-medium ml-2 opacity-80">/month</span>
            </div>
            <p class="text-blue-100 text-base sm:text-lg">Never miss a high-paying job again. Perfect for time-poor Aussie tradies.</p>
            
            <!-- Value Proposition -->
            <div class="mt-4 sm:mt-6 bg-blue-500/30 rounded-lg p-3 sm:p-4">
              <div class="text-sm sm:text-base font-bold text-blue-100 mb-1">Break-even calculation:</div>
              <div class="text-sm sm:text-base font-semibold">Win one extra job per month and turn $29 into $500.</div>
              <div class="text-sm sm:text-base font-semibold">That's a 1,567% ROI – no brainer.</div>
            </div>
          </div>

          <!-- Features -->
          <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
              <div v-for="(benefit, index) in benefits" :key="index" 
                   class="flex items-start group hover:bg-blue-50 rounded-lg p-3 sm:p-4 transition-all duration-300">
                <div class="bg-green-100 rounded-lg p-2 sm:p-3 mr-3 sm:mr-4 group-hover:bg-green-200 transition-colors flex-shrink-0">
                  <font-awesome-icon :icon="benefit.icon" class="text-green-600 text-base sm:text-lg" />
                </div>
                <div class="flex-1 min-w-0">
                  <div class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">{{ benefit.highlight }}</div>
                  <div class="text-gray-600 text-xs sm:text-sm leading-relaxed">{{ benefit.text }}</div>
                </div>
              </div>
            </div>

            <!-- CTA Button -->
            <div class="text-center mb-4 sm:mb-6">
              <Button unstyled @click="visit(route('onboarding.show'))" class="cursor-pointer inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 text-sm sm:text-base">
                <font-awesome-icon :icon="['fas', 'rocket']" class="mr-2" />
                Get Started for $1 a Day
              </Button>
            </div>

            <!-- What Happens Next -->
            <div class="text-center text-xs sm:text-sm text-gray-600 mb-4 sm:mb-6">
              <p class="mb-1 font-semibold">What happens next?</p>
              <p>Enter your rates → get your local number → start replying instantly. All in under 5 minutes.</p>
            </div>

            <!-- Trust Signals -->
            <div class="text-center text-xs sm:text-sm text-gray-500 mb-4 sm:mb-6">
              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-center space-y-2 sm:space-y-0 sm:space-x-6">
                <span class="flex items-center justify-center sm:justify-start">
                  <font-awesome-icon :icon="['fas', 'fa-piggy-bank']" class="mr-2" />
                  30-day money back guarantee
                </span>
                <span class="flex items-center justify-center sm:justify-start">
                  <font-awesome-icon :icon="['fas', 'fa-times-circle']" class="mr-2" />
                  Cancel anytime
                </span>
                <span class="flex items-center justify-center sm:justify-start">
                  <font-awesome-icon :icon="['fas', 'fa-envelope']" class="mr-2" />
                  Support included
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Social Proof & Additional Benefits -->
      <div class="mt-8 sm:mt-12 text-center">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
          <div v-for="(point, index) in proofPoints" :key="index" 
               class="flex items-center justify-center bg-white rounded-lg p-3 sm:p-4 shadow-md border border-gray-100 hover:shadow-lg transition-shadow">
            <div class="bg-green-100 rounded-full p-2 mr-3 flex-shrink-0">
              <font-awesome-icon :icon="point.icon" class="text-green-600 text-sm sm:text-base" />
            </div>
            <span class="text-gray-700 font-medium text-sm sm:text-base">{{ point.text }}</span>
          </div>
        </div>
      </div>

      <!-- Money Back Guarantee -->
      <div class="mt-8 sm:mt-12 text-center">
        <div class="inline-flex items-center justify-center w-full bg-green-50 border border-green-200 rounded-xl p-4 sm:p-6">
          <div class="bg-green-100 rounded-full p-2 sm:p-3 mr-3 sm:mr-4 flex-shrink-0">
            <font-awesome-icon :icon="['fas', 'fa-shield-alt']" class="text-green-600 text-xl sm:text-2xl" />
          </div>
          <div class="text-left min-w-0">
            <div class="font-bold text-green-900 text-base sm:text-lg">30-Day Money Back Guarantee</div>
            <div class="text-green-700 text-sm sm:text-base">If you don't win at least one extra job in 30 days, get your money back.</div>
          </div>
        </div>
      </div>
    </div>
</template>
