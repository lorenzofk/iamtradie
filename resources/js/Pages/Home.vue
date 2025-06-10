<script setup>
import { ref } from 'vue';
import Layout from '@/Layouts/App.vue';
import { router } from '@inertiajs/vue3';
import Select from '@/Shared/Ui/Form/Select.vue';
import Input from '@/Shared/Ui/Form/Input.vue';
import Drawer from '@Shared/Ui/Overlay/Drawer.vue';
import ShowQuote from './Quotes/Show.vue';

defineOptions({
  layout: Layout,
});

const props = defineProps({
  stats: Object,
  quotes: Array,
});

const searchQuery = ref('');
const showDrawer = ref(false);
const selectedQuote = ref(null);
const statusFilter = ref('All Status');

const statusOptions = [
  { label: 'All Status', value: 'All Status' },
  { label: 'Pending', value: 'pending' },
  { label: 'Sent', value: 'sent' },
  { label: 'Rejected', value: 'rejected' },
];

const getStatusBadgeClass = (status) => {
  switch (status) {
    case 'sent':
      return 'bg-green-100 text-green-800';
    case 'pending':
      return 'bg-yellow-100 text-yellow-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};

const openQuoteDrawer = (quote) => {
  selectedQuote.value = quote;
  showDrawer.value = true;
};

const closeDrawer = () => {
  showDrawer.value = false;
  selectedQuote.value = null;

  router.visit(route('quotes.index'));
};


</script>

<template>
  <div class="max-w-6xl mx-auto py-4 lg:py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4 lg:mb-6 bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
      <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6 mb-6 lg:mb-8">
      <!-- New Inquiries -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="flex items-center">
          <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <font-awesome-icon :icon="['fas', 'fa-envelope']" class="text-blue-600 text-sm lg:text-lg" />
          </div>
          <div class="ml-3 lg:ml-4 min-w-0">
            <p class="text-xs lg:text-sm font-medium text-gray-500">New Inquiries</p>
            <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ stats.new_inquiries }}</p>
          </div>
        </div>
      </div>

      <!-- Sent Today -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="flex items-center">
          <div class="w-10 h-10 lg:w-12 lg:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="text-green-600 text-sm lg:text-lg" />
          </div>
          <div class="ml-3 lg:ml-4 min-w-0">
            <p class="text-xs lg:text-sm font-medium text-gray-500">Sent Today</p>
            <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ stats.sent_today }}</p>
          </div>
        </div>
      </div>

      <!-- Pending Review -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="flex items-center">
          <div class="w-10 h-10 lg:w-12 lg:h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-yellow-600 text-sm lg:text-lg" />
          </div>
          <div class="ml-3 lg:ml-4 min-w-0">
            <p class="text-xs lg:text-sm font-medium text-gray-500">Pending Review</p>
            <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ stats.pending_review }}</p>
          </div>
        </div>
      </div>

      <!-- Est. Value -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="flex items-center">
          <div class="w-10 h-10 lg:w-12 lg:h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <font-awesome-icon :icon="['fas', 'fa-dollar-sign']" class="text-orange-600 text-sm lg:text-lg" />
          </div>
          <div class="ml-3 lg:ml-4 min-w-0">
            <p class="text-xs lg:text-sm font-medium text-gray-500">Est. Value</p>
            <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ stats.estimated_value }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-xl shadow-sm border-0 overflow-hidden">
      <!-- Header with Filters -->
      <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col gap-4">
          <h2 class="text-lg font-semibold text-gray-900">Recent Inquiries</h2>
          
          <div class="flex flex-col sm:flex-row gap-3">
            <!-- Search -->
            <div class="relative flex-1">
              <Input
                v-model="searchQuery"
                type="text"
                placeholder="Search quotes..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm"
              />
            </div>

            <!-- Filters -->
            <div class="w-full sm:w-48">
              <Select
                v-model="statusFilter"
                :options="statusOptions"
                optionLabel="label"
                optionValue="value"
                class="w-full"
                placeholder="Select status"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Desktop Table -->
      <div class="hidden lg:block px-6 py-4">
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="text-left py-3 px-2 text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                <th class="text-left py-3 px-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Client Message</th>
                <th class="text-left py-3 px-2 text-xs font-medium text-gray-500 uppercase tracking-wider">AI Reply Preview</th>
                <th class="text-left py-3 px-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                <th class="text-right py-3 px-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="quote in quotes" :key="quote.id" class="hover:bg-gray-50">
                <td class="py-4 px-2">
                  <span
                    class="px-2 py-1 rounded-full text-xs font-medium"
                    :class="getStatusBadgeClass(quote.status)"
                  >
                    {{ quote.status }}
                  </span>
                </td>

                <td class="py-4 px-2 text-sm text-gray-900">
                  {{ quote.from_number }}
                </td>

                <td class="py-4 px-2 text-sm text-gray-900 max-w-xs">
                  <div class="truncate">{{ quote.message }}</div>
                </td>

                <td class="py-4 px-2 text-sm text-gray-600 max-w-xs">
                  <div class="truncate">{{ quote.ai_response }}</div>
                </td>

                <td class="py-4 px-2 text-sm text-gray-500">
                  {{ quote.created_at }}
                </td>

                <!-- Actions -->
                <td class="py-4 px-2 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button
                      @click="openQuoteDrawer(quote)"
                      class="text-blue-600 hover:text-blue-700 text-sm font-medium cursor-pointer"
                    >
                      View
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Mobile Cards -->
      <div class="lg:hidden">
        <div v-if="quotes.length === 0" class="px-4 py-8 text-center">
          <font-awesome-icon :icon="['fas', 'fa-inbox']" class="text-gray-300 text-4xl mb-4" />
          <h3 class="text-lg font-medium text-gray-900 mb-2">No quotes found</h3>
          <p class="text-gray-500">You have no quotes yet.</p>
        </div>
        
        <div v-else class="divide-y divide-gray-200">
          <div 
            v-for="quote in quotes" 
            :key="quote.id" 
            class="px-4 py-4 hover:bg-gray-50 cursor-pointer"
            @click="openQuoteDrawer(quote)"
          >
            <div class="flex items-start justify-between mb-3">
              <div class="flex items-center gap-3">
                <span
                  class="px-2 py-1 rounded-full text-xs font-medium flex-shrink-0"
                  :class="getStatusBadgeClass(quote.status)"
                >
                  {{ quote.status }}
                </span>
                <span class="text-sm font-medium text-gray-900">{{ quote.from_number }}</span>
              </div>
              <span class="text-xs text-gray-500 flex-shrink-0">{{ quote.created_at }}</span>
            </div>
            
            <div class="space-y-2">
              <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Client Message</p>
                <p class="text-sm text-gray-900 overflow-hidden" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ quote.message }}</p>
              </div>
              
              <div v-if="quote.ai_response">
                <p class="text-xs font-medium text-gray-500 mb-1">AI Reply Preview</p>
                <p class="text-sm text-gray-600 overflow-hidden" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ quote.ai_response }}</p>
              </div>
            </div>
            
            <div class="flex justify-end mt-3">
              <button
                @click.stop="openQuoteDrawer(quote)"
                class="text-blue-600 hover:text-blue-700 text-sm font-medium"
              >
                View Details →
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Drawer -->
  <Drawer
    v-model:visible="showDrawer"
    position="right"
    :modal="true"
    :dismissableMask="true"
    :style="{ width: '480px' }"
    class="lg:block"
  >
    <template #header>
      <div class="flex flex-col w-full py-2 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Quote Details</h2>
        <p class="text-sm text-gray-500 mt-1">Review and manage this quote</p>
      </div>
    </template>
    <ShowQuote :quote="selectedQuote" @success="closeDrawer" @cancel="closeDrawer" />
  </Drawer>
</template>