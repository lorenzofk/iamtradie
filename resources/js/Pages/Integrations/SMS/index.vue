<script setup>
import { ref } from 'vue';
import Layout from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';

defineOptions({
  layout: Layout,
});

const props = defineProps({
  sms_data: Object,
  sms_settings: Object
});

const copyPhoneNumber = () => {
  console.log('copyPhoneNumber');
};

</script>
<template>
  <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6 bg-white rounded-xl shadow-sm border-0 p-6">
      <h1 class="text-2xl font-bold text-gray-900">SMS Integration</h1>
      <div>
          <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-gray-100 rounded-full flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-chart-line']" class="text-gray-600 text-sm" />
            </div>
            <div class="text-sm">
              <span class="font-medium text-gray-900">{{ props.sms_data.quotes_used }}</span>
              <span class="text-gray-500"> / {{ props.sms_data.quotes_limit }} quotes used</span>
            </div>
          </div>
          <!-- Progress Bar -->
          <div class="mt-1 w-full h-1 bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-blue-500 rounded-full transition-all duration-300" :style="{ width: `${(props.sms_data.quotes_used / props.sms_data.quotes_limit) * 100}%` }"></div>
          </div>
      </div>
    </div>
    
    <div class="space-y-8">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Messages -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-blue-600" />
            </div>
            <div>
              <p class="text-sm text-gray-600">Total Messages</p>
              <p class="text-2xl font-bold text-gray-900">{{ props.sms_data.total_messages }}</p>
            </div>
          </div>
        </div>
        <!-- Pending Review -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-orange-600" />
            </div>
            <div>
              <p class="text-sm text-gray-600">Pending Review</p>
              <p class="text-2xl font-bold text-gray-900">{{ props.sms_data.pending_review }}</p>
            </div>
          </div>
        </div>
        <!-- Auto-Sent -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-600" />
            </div>
            <div>
              <p class="text-sm text-gray-600">Auto-Sent</p>
              <p class="text-2xl font-bold text-gray-900">{{ props.sms_data.auto_sent_enabled }}</p>
            </div>
          </div>
        </div>
        <!-- Response Rate -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-paper-plane']" class="text-purple-600" />
            </div>
            <div>
              <p class="text-sm text-gray-600">Response Rate</p>
              <p class="text-2xl font-bold text-gray-900">{{ props.sms_data.response_rate }}</p>
            </div>
          </div>
        </div>
      </div>
      <!-- SMS Number Section (keeping your original) -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
            <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-blue-600" />
          </div>
          <div>
            <h2 class="text-lg font-semibold text-gray-900">Your SMS Number</h2>
            <p class="text-sm text-gray-600">Dedicated phone number for receiving quote requests</p>
          </div>
        </div>
        <!-- Active SMS Number -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="text-green-600" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-900">Active SMS Number</p>
              <p class="text-lg font-semibold text-green-800">{{ props.sms_data.agent_sms_number }}</p>
            </div>
          </div>
          <Button
            @click="copyPhoneNumber"
            size="small"
            label="Copy"
            outlined
            :icon="['fas', 'fa-copy']"
          />
        </div>
        <!-- SMS Configuration (subtle addition) -->
        <div class="pt-4 border-t border-gray-100">
          <h3 class="text-sm font-medium text-gray-900 mb-3">Current Configuration</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Auto-Send Status -->
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon 
                  :icon="['fas', 'fa-bolt']" 
                  class="text-blue-600 text-sm" 
                />
                <span class="text-sm text-gray-700">Auto-Send</span>
              </div>
              <span class="text-xs font-medium text-green-700">
                {{ props.sms_settings.auto_send_sms ? 'On' : 'Off' }}
              </span>
            </div>
            <!-- Pricing -->
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon 
                  :icon="['fas', 'fa-dollar-sign']" 
                  class="text-orange-600 text-sm" 
                />
                <span class="text-sm text-gray-700">Rates</span>
              </div>
              <span class="text-xs font-medium text-gray-900">
                ${{ props.sms_settings.callout_fee }} + ${{ props.sms_settings.hourly_rate }}/hr
              </span>
            </div>
            <!-- Response Tone -->
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon 
                  :icon="['fas', 'fa-comment-dots']" 
                  class="text-purple-600 text-sm" 
                />
                <span class="text-sm text-gray-700">Tone</span>
              </div>
              <span class="text-xs font-medium text-gray-900 capitalize">
                {{ props.sms_settings.response_tone }}
              </span>
            </div>
          </div>
        </div>
      </div>
      <!-- How SMS Integration Works -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="mb-6">
          <h2 class="text-lg font-semibold text-gray-900">How SMS Integration Works</h2>
          <p class="text-sm text-gray-600 mt-1">Automatic quote generation and response system</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Step 1 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
              <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-blue-600 text-xl" />
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-2">1. Customer Texts</h3>
            <p class="text-sm text-gray-600">Customer sends quote request to your SMS number</p>
          </div>
          <!-- Step 2 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
              <font-awesome-icon :icon="['fas', 'fa-cog']" class="text-green-600 text-xl" />
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-2">2. AI Generates Quote</h3>
            <p class="text-sm text-gray-600">System creates professional quote using your rates</p>
          </div>
          <!-- Step 3 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4">
              <font-awesome-icon :icon="['fas', 'fa-paper-plane']" class="text-purple-600 text-xl" />
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-2">3. Auto Response</h3>
            <p class="text-sm text-gray-600">Quote sent back automatically or saved for review</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>