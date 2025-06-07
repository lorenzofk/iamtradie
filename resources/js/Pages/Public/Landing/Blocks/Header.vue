<script setup>
const emit = defineEmits(['scroll-to-section']);
</script>

<template>
    <header class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center">
            <img src="/images/logo.png" alt="PingMate Logo" class="h-12 w-12 transform scale-200 mr-2" />
            <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">PingMate</span>
          </div>
          <nav class="hidden md:flex space-x-8">
            <a href="#problem" @click.prevent="emit('scroll-to-section', 'problem')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">The Problem</a>
            <a href="#solution" @click.prevent="emit('scroll-to-section', 'solution')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">How It Works</a>
            <a href="#pricing" @click.prevent="emit('scroll-to-section', 'pricing')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Pricing</a>
          </nav>
          <div class="flex space-x-4">
            <a :href="route('onboarding.show')" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 shadow-lg transition-all">
              Get started for $1 a day
            </a>
            <a :href="route('login')" class="inline-flex items-center px-4 py-2 border border-blue-600 rounded-md text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 transition-colors">
              Login
            </a>
          </div>
        </div>
      </div>
    </header>
</template>