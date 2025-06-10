<script setup>
import { router } from '@inertiajs/vue3'

const emit = defineEmits(['scroll-to-section']);
import Button from '@/Shared/Ui/Button/Button.vue';

const visit = (url) => {
  router.visit(url);
};
</script>

<template>
  <div class="absolute inset-0">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-green-600/20"></div>
    <div class="absolute top-0 left-0 w-48 h-48 sm:w-72 sm:h-72 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 sm:w-96 sm:h-96 bg-green-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1000ms"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-56 h-56 sm:w-80 sm:h-80 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 500ms"></div>
  </div>
      
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="mb-4 sm:mb-6">
      <span class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-full text-xs sm:text-sm font-semibold shadow-lg">
        🇦🇺 Made for Australian Hard Workers
      </span>
    </div>

    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-5xl font-extrabold text-white mb-4 sm:mb-6 leading-tight">
      Never Miss Another Opportunity<br />
      <span class="bg-gradient-to-r from-sky-400 to-blue-400 bg-clip-text text-transparent drop-shadow-md">AI-Powered SMS & Call Handling for Busy Professionals</span>
    </h1>

    <p class="text-base sm:text-lg text-blue-100 max-w-5xl mx-auto leading-relaxed mb-4">
      PingMate ensures you respond instantly, whether it's a text or a call, even when you're flat out or off the clock.
      <br class="hidden sm:block">
      Your AI assistant replies in your voice, using your pricing and service info. You’re always the first to respond and win the job.
    </p>

    <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6 mt-6 sm:mt-8">
      <Button unstyled label="🚀 Get Started Now" @click="visit(route('onboarding.show'))" class="cursor-pointer inline-flex items-center justify-center px-8 sm:px-12 py-3 sm:py-4 text-base sm:text-lg bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold" />
      <Button unstyled @click="emit('scroll-to-section', 'how-it-works')" class="cursor-pointer inline-flex items-center justify-center px-8 sm:px-12 py-3 sm:py-4 text-base sm:text-lg border-2 border-sky-400/80 text-sky-200 bg-sky-500/10 backdrop-blur-sm hover:bg-sky-400 hover:text-slate-900 shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold">
        <font-awesome-icon :icon="['fas', 'fa-comments']" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" />
        See How It Works
      </Button>
    </div>

    <!-- Optional teaser section for added clarity -->
    <div class="mt-8 text-sky-200">
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-md sm:max-w-3xl mx-auto text-sm sm:text-base">
        <div class="flex items-center gap-2 justify-center">
          <font-awesome-icon :icon="['fas', 'fa-comment-dots']" />
          <span>Instant SMS Replies</span>
        </div>
        <div class="flex items-center gap-2 justify-center">
          <font-awesome-icon :icon="['fas', 'fa-phone-slash']" />
          <span>Smart Missed Call Summaries</span>
        </div>
        <div class="flex items-center gap-2 justify-center">
          <font-awesome-icon :icon="['fas', 'fa-map-marker-alt']" />
          <span>Local Aussie Number</span>
        </div>
      </div>
    </div>

  </div>
</template>