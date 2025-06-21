<script setup>
import { router } from '@inertiajs/vue3';
import Button from '@/Shared/Ui/Button/Button.vue';

const emit = defineEmits(['scroll-to-section']);

const visit = url => {
  router.visit(url);
};
</script>

<template>
  <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-4 sm:mb-6">
      Stop Losing Jobs to Faster Competitors
    </h2>
    <p class="text-lg sm:text-xl text-blue-100 mb-6 sm:mb-8 leading-relaxed">
      Join 100+ Australian workers who never miss another SMS lead.
      <span class="text-yellow-300 font-semibold">Start now, mate</span>
    </p>

    <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
      <Button
        unstyled
        @click="visit(route('onboarding.show'))"
        class="cursor-pointer inline-flex items-center justify-center px-8 sm:px-12 py-3 sm:py-4 text-base sm:text-lg bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold"
      >
        <font-awesome-icon :icon="['fas', 'rocket']" class="mr-2" />
        Get Started Now
      </Button>
    </div>

    <p class="text-blue-200 mt-4 sm:mt-6 text-xs sm:text-sm">
      ✓ 30-day money back guarantee ✓ Australian phone number included ✓ Cancel anytime
    </p>
  </div>
</template>
