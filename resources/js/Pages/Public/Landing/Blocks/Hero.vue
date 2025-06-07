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
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1000ms"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 500ms"></div>
  </div>
      
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="mb-6">
      <span class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-6 py-3 rounded-full text-sm font-semibold shadow-lg">
      🇦🇺 Made for Australian Hard Workers
      </span>
    </div>
    <h1 class="text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
      Never Miss Another SMS & Win Jobs<br />
      <span class="bg-gradient-to-r from-sky-400 to-blue-400 bg-clip-text text-transparent">While Competitors Sleep</span>
    </h1>
    <p class="text-xl text-blue-100 max-w-4xl mx-auto leading-relaxed mb-2">
      Your AI agent responds to customer texts in seconds with professional quotes using your pricing.
      <br>Get your own Australian phone number and embedded website forms. 
    </p>
    
    <span class="text-yellow-300 font-semibold">
      <font-awesome-icon :icon="['fas', 'fa-bolt']" class="h-5 w-5" />
      First to reply usually gets the job.
    </span>

    <div class="flex flex-col sm:flex-row justify-center gap-6 mt-8">
      <Button unstyled label="🚀 Start now for $1 a day" @click="visit(route('onboarding.show'))" class="cursor-pointer inline-flex items-center justify-center px-12 py-4 text-lg bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold" />
      <Button unstyled @click="emit('scroll-to-section', 'how-it-works')" class="cursor-pointer inline-flex items-center justify-center px-12 py-4 text-lg border-2 border-sky-400/80 text-sky-200 bg-sky-500/10 backdrop-blur-sm hover:bg-sky-400 hover:text-slate-900 shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold">
        <font-awesome-icon :icon="['fas', 'fa-comments']" class="h-5 w-5 mr-2" />
        See How It Works
      </Button>
    </div>
  </div>
</template>