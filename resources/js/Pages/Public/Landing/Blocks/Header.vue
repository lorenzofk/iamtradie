<script setup>
import { router } from '@inertiajs/vue3';

const emit = defineEmits(['scroll-to-section']);

import Button from '@/Shared/Ui/Button/Button.vue';

const visit = url => {
  router.visit(url);
};
</script>

<template>
  <header class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <div class="flex items-center">
          <img src="/images/logo.png" alt="PingMate Logo" class="ml-4 md:ml-0 h-12 w-12 transform scale-220" />
        </div>
        <nav class="hidden md:flex space-x-8">
          <a
            href="#problem"
            @click.prevent="emit('scroll-to-section', 'problem')"
            class="text-gray-700 hover:text-blue-600 font-medium transition-colors"
          >
            The Problem
          </a>
          <a
            href="#solution"
            @click.prevent="emit('scroll-to-section', 'solution')"
            class="text-gray-700 hover:text-blue-600 font-medium transition-colors"
          >
            How It Works
          </a>
          <a
            href="#pricing"
            @click.prevent="emit('scroll-to-section', 'pricing')"
            class="text-gray-700 hover:text-blue-600 font-medium transition-colors"
          >
            Pricing
          </a>
        </nav>
        <div class="flex space-x-4">
          <Button
            unstyled
            @click="visit(route('onboarding.show'))"
            class="cursor-pointer inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 shadow-lg transition-all"
          >
            <font-awesome-icon :icon="['fas', 'rocket']" class="mr-2" />
            Get Started
          </Button>
          <Button
            unstyled
            label="Login"
            @click="visit(route('login'))"
            class="cursor-pointer inline-flex items-center px-4 py-2 border border-blue-600 rounded-md text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 transition-colors"
          />
        </div>
      </div>
    </div>
  </header>
</template>
