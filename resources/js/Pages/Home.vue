<script setup>
import { ref } from 'vue';
import Layout from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import { router } from '@inertiajs/vue3';
import Select from '@/Shared/Ui/Form/Select.vue';
import Input from '@/Shared/Ui/Form/Input.vue';

defineOptions({
  layout: Layout,
});

const props = defineProps({
  stats: Object,
  quotes: Array,
});

const searchQuery = ref('');
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

const onNewQuoteClick = () => {
  router.visit(route('quotes.index'));
};

const reviewQuote = (quote) => {
  router.visit(`/quotes/${quote.id}`);
};

const deleteQuote = (quote) => {
  if (confirm('Are you sure you want to delete this quote?')) {
    console.log('Delete quote:', quote.id);
  }
};
</script>

<template>
  <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6 bg-white rounded-xl shadow-sm border-0 p-6">
      <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- New Inquiries -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <font-awesome-icon :icon="['fas', 'fa-envelope']" class="text-blue-600 text-lg" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">New Inquiries</p>
            <p class="text-2xl font-semibold text-gray-900">{{ stats.new_inquiries }}</p>
          </div>
        </div>
      </div>

      <!-- Sent Today -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="text-green-600 text-lg" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Sent Today</p>
            <p class="text-2xl font-semibold text-gray-900">{{ stats.sent_today }}</p>
          </div>
        </div>
      </div>

      <!-- Pending Review -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
            <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-yellow-600 text-lg" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Pending Review</p>
            <p class="text-2xl font-semibold text-gray-900">{{ stats.pending_review }}</p>
          </div>
        </div>
      </div>

      <!-- Est. Value -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
            <font-awesome-icon :icon="['fas', 'fa-dollar-sign']" class="text-orange-600 text-lg" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Est. Value</p>
            <p class="text-2xl font-semibold text-gray-900">{{ stats.estimated_value }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-xl shadow-sm border-0 overflow-hidden">
      <!-- Header with Filters -->
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div class="flex flex-col sm:flex-row sm:items-center gap-4 flex-1">
            <!-- Search -->
            <div class="relative flex-1 max-w-md">
              <Input
                v-model="searchQuery"
                type="text"
                placeholder="Search quotes..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm"
              />
            </div>

            <!-- Filters -->
            <div class="flex gap-3">
              <Select
                v-model="statusFilter"
                :options="statusOptions"
                optionLabel="label"
                optionValue="value"
                class="w-48"
                placeholder="Select status"
              />
            </div>
          </div>

          <!-- New Quote Button -->
          <Button
            @click="onNewQuoteClick"
            label="New Quote"
            :icon="['fas', 'fa-plus']"
          />
        </div>
      </div>

      <!-- Recent Inquiries Table -->
      <div class="px-6 py-4">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Inquiries</h2>
        
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
                      @click="reviewQuote(quote)"
                      class="text-blue-600 hover:text-blue-700 text-sm font-medium"
                    >
                      Review
                    </button>
                    <button
                      @click="deleteQuote(quote)"
                      class="text-gray-400 hover:text-red-600 ml-2"
                    >
                      <font-awesome-icon :icon="['fas', 'fa-trash']" class="text-sm" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>