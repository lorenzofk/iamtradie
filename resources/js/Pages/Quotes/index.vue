<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import App from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import Drawer from '@Shared/Ui/Overlay/Drawer.vue';
import ShowQuote from './Show.vue';
import { useToast } from '@Shared/Ui/Hooks/useToast';

const { showToast } = useToast();

defineOptions({
  layout: App,
});

const props = defineProps({
  quotes: Array,
});

const showDrawer = ref(false);
const selectedQuote = ref(null);

const openQuoteDrawer = quote => {
  selectedQuote.value = quote;
  showDrawer.value = true;
};

const closeDrawer = () => {
  showDrawer.value = false;
  selectedQuote.value = null;

  router.visit(route('quotes.index'));
};

const onDeleteClick = quote => {
  if (confirm('Are you sure you want to delete this quote?')) {
    axios
      .delete(route('quotes.destroy', quote.id))
      .then(() => {
        showToast('success', 'Quote deleted successfully.');
        router.visit(route('quotes.index'));
      })
      .catch(() => {
        showToast('error', 'Failed to delete quote.');
      });
  }
};

const onSendClick = async quote => {
  await axios
    .post(route('quotes.send', quote.id))
    .then(() => {
      showToast('success', 'Quote sent successfully.');
    })
    .catch(() => {
      showToast('error', 'Failed to send quote.');
    });

  router.reload({ only: ['quotes'] });
};
</script>

<template>
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div
      class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 lg:mb-6 bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6 gap-4"
    >
      <div>
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Messages</h1>
        <p class="text-gray-600 text-sm mt-1">Manage and review your customer conversations</p>
      </div>
      <div class="text-sm text-gray-500 bg-gray-50 rounded-lg px-3 py-1.5 self-start sm:self-auto">
        {{ quotes.length }} Messages
      </div>
    </div>

    <!-- Main Content Wrapper -->
    <div class="bg-white rounded-xl shadow-sm border-0 overflow-hidden">
      <!-- Content Area -->
      <div class="p-4 lg:p-6">
        <!-- Empty State -->
        <div v-if="quotes.length === 0" class="text-center py-8 lg:py-12">
          <div class="bg-gray-50 rounded-xl p-6 lg:p-8 max-w-sm mx-auto">
            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3">
              <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-blue-500 text-lg" />
            </div>
            <h3 class="text-base font-medium text-gray-900 mb-1">No messages yet</h3>
            <p class="text-gray-500 text-sm">Start receiving messages from your customers</p>
          </div>
        </div>

        <!-- Quote Cards -->
        <div v-else class="space-y-4 lg:space-y-8">
          <div
            v-for="quote in quotes"
            :key="quote.id"
            class="bg-gray-50 rounded-xl hover:shadow-sm transition-shadow duration-200 border border-gray-200 overflow-hidden"
          >
            <!-- Header -->
            <div class="px-4 lg:px-5 py-3 lg:py-4 bg-white border-b border-gray-200">
              <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2 lg:gap-3">
                  <!-- Status Badge -->
                  <span
                    class="px-2 lg:px-3 py-1 rounded-full text-xs font-medium flex-shrink-0"
                    :class="{
                      'bg-green-50 text-green-700': quote.status === 'sent',
                      'bg-yellow-50 text-yellow-700': quote.status === 'pending',
                      'bg-red-50 text-red-700': quote.status === 'rejected',
                      'bg-gray-50 text-gray-700': quote.status === 'draft',
                    }"
                  >
                    <font-awesome-icon
                      :icon="[
                        'fas',
                        quote.status === 'sent'
                          ? 'fa-check-circle'
                          : quote.status === 'pending'
                            ? 'fa-clock'
                            : 'fa-times-circle',
                      ]"
                      class="mr-1.5"
                    />
                    {{ quote.status }}
                  </span>

                  <!-- Phone number on mobile -->
                  <span class="text-xs font-medium text-gray-600 sm:hidden">
                    {{ quote.from_number }}
                  </span>
                </div>

                <!-- Date -->
                <span class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-md flex-shrink-0">
                  {{
                    new Date(quote.created_at).toLocaleDateString('en-AU', {
                      day: 'numeric',
                      month: 'short',
                      year: 'numeric',
                    })
                  }}
                </span>
              </div>
            </div>

            <!-- Conversation -->
            <div class="px-4 lg:px-5 py-4 lg:py-5 bg-white space-y-3 lg:space-y-4">
              <!-- Client Message -->
              <div class="flex gap-2 lg:gap-3">
                <div
                  class="w-7 h-7 lg:w-8 lg:h-8 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0"
                >
                  <font-awesome-icon :icon="['fas', 'fa-user']" class="text-gray-500 text-xs lg:text-sm" />
                </div>
                <div class="flex-1 min-w-0">
                  <div class="bg-gray-50 rounded-2xl rounded-tl-sm p-3 lg:p-4">
                    <div class="flex items-center gap-2 mb-2">
                      <span class="text-xs font-medium text-gray-900">Client</span>
                      <span class="text-xs text-gray-500">
                        {{ new Date(quote.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}
                      </span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ quote.message }}</p>
                  </div>
                </div>
              </div>

              <!-- Your Response -->
              <div class="flex gap-2 lg:gap-3 justify-end">
                <div class="flex-1 min-w-0 flex justify-end">
                  <div class="max-w-[85%] lg:max-w-[80%] bg-blue-500 rounded-2xl rounded-tr-sm p-3 lg:p-4 text-white">
                    <div class="flex items-center gap-2 mb-2 justify-end">
                      <span class="text-xs text-blue-100">
                        {{
                          quote.sent_at
                            ? new Date(quote.sent_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                            : 'Not sent'
                        }}
                      </span>
                      <span class="text-xs font-medium">You</span>
                    </div>
                    <p class="text-sm leading-relaxed text-right">{{ quote.edited_response || quote.ai_response }}</p>
                  </div>
                </div>
                <div
                  class="w-7 h-7 lg:w-8 lg:h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0"
                >
                  <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-white text-xs lg:text-sm" />
                </div>
              </div>
            </div>

            <!-- Footer -->
            <div class="px-4 lg:px-5 py-3 bg-white border-t border-gray-200">
              <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-1 text-xs text-gray-500">
                  <font-awesome-icon :icon="['fas', 'fa-hashtag']" />
                  <span>Quote {{ quote.id }}</span>
                  <!-- Show phone number on desktop -->
                  <span class="hidden sm:inline ml-2">• {{ quote.from_number }}</span>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                  <Button
                    @click="onDeleteClick(quote)"
                    label="Delete"
                    size="small"
                    :icon="['fas', 'fa-trash']"
                    class="!text-red-600 hover:!text-red-700 hover:!bg-red-0 !bg-red-50 !border-red-200 flex-1 sm:flex-none min-w-0"
                  />
                  <Button
                    @click="openQuoteDrawer(quote)"
                    label="View"
                    size="small"
                    outlined
                    :icon="['fas', 'fa-eye']"
                    class="flex-1 sm:flex-none min-w-0"
                  />
                  <Button
                    v-if="quote.status === 'pending'"
                    @click="onSendClick(quote)"
                    label="Send SMS"
                    size="small"
                    :icon="['fas', 'fa-paper-plane']"
                    class="flex-1 sm:flex-none min-w-0"
                  />
                </div>
              </div>
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
