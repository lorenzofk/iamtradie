<script setup>
const emit = defineEmits(['scroll-to-section']);
</script>

<template>
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
    <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
        Stop Losing Jobs to Faster Competitors
    </h2>
    <p class="text-xl text-blue-100 mb-8 leading-relaxed">
        Join 100+ Australian tradies who never miss another SMS lead. 
        <span class="text-yellow-300 font-semibold">Start now, mate</span>
    </p>
    
    <div class="flex flex-col sm:flex-row justify-center gap-6">
        <a :href="route('onboarding.show')" class="inline-flex items-center justify-center px-12 py-4 text-lg bg-white hover:bg-gray-100 text-blue-600 shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold">
        🚀 Start now for $1 a day
        </a>
    </div>
    
    <p class="text-blue-200 mt-6 text-sm">
        ✓ 30-day money back guarantee ✓ Australian phone number included ✓ Cancel anytime
    </p>
    </div>
</template>