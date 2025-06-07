<script setup>
import Public from '@/Layouts/Public.vue';
import NextStepsDetails from './Blocks/NextStepsDetails.vue';
import PhoneNumberDetails from './Blocks/PhoneNumberDetails.vue';
import PlanSummaryDetails from './Blocks/PlanSummaryDetails.vue';

defineOptions({
  layout: Public,
});

const props = defineProps({
  planType: String,
  businessName: String,
  firstName: String,
  phoneNumber: String,
});
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
        <h1 class="text-4xl font-black text-white mb-4">Welcome to PingMate!</h1>
        <p class="text-xl text-green-100 mb-2">Payment successful – Your AI assistant is locked and loaded</p>
      </div>

      <!-- Content -->
      <div class="space-y-8">
        <PhoneNumberDetails :phoneNumber="phoneNumber" />
        <PlanSummaryDetails :planType="planType" :businessName="businessName" />
        <NextStepsDetails />
      </div>
    </div>
  </div>
</template>