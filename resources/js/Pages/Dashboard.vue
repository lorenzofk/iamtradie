<script setup>
import { ref } from 'vue';
import Layout from '@/Layouts/App.vue';
import { router } from '@inertiajs/vue3';
import Select from '@/Shared/Ui/Form/Select.vue';
import Input from '@/Shared/Ui/Form/Input.vue';
import Drawer from '@Shared/Ui/Overlay/Drawer.vue';
import ShowQuote from './Quotes/Show.vue';
import ShowVoicemail from './Voicemails/Show.vue';

defineOptions({
  layout: Layout,
});

const props = defineProps({
  stats: Object,
  voicemail_stats: Object,
  quotes: Array,
  voicemails: Array,
});

const searchQuery = ref('');
const showDrawer = ref(false);
const selectedQuote = ref(null);
const statusFilter = ref('All Status');

// Voicemail drawer state
const selectedVoicemail = ref(null);
const showVoicemailDrawer = ref(false);

const statusOptions = [
  { label: 'All Status', value: 'All Status' },
  { label: 'Pending', value: 'pending' },
  { label: 'Sent', value: 'sent' },
  { label: 'Rejected', value: 'rejected' },
];

const getStatusBadgeClass = status => {
  switch (status) {
    case 'sent':
      return 'bg-green-100 text-green-800';
    case 'pending':
      return 'bg-yellow-100 text-yellow-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};

const getStatusIcon = status => {
  switch (status) {
    case 'sent':
      return 'fa-check-circle';
    case 'pending':
      return 'fa-clock';
    default:
      return 'fa-circle';
  }
};

// Voicemail helpers
const formatDuration = seconds => {
  if (!seconds) return 'N/A';
  const mins = Math.floor(seconds / 60);
  const secs = seconds % 60;
  return `${mins}:${secs.toString().padStart(2, '0')}`;
};

const getVoicemailStatusBadgeClass = voicemail => {
  if (voicemail.sms_sent) {
    return 'bg-green-100 text-green-800';
  } else if (voicemail.transcription_processed) {
    return 'bg-blue-100 text-blue-800';
  } else {
    return 'bg-yellow-100 text-yellow-800';
  }
};

const getVoicemailStatusText = voicemail => {
  if (voicemail.sms_sent) {
    return 'Responded';
  } else if (voicemail.transcription_processed) {
    return 'Transcribed';
  } else {
    return 'Processing';
  }
};

const getVoicemailStatusIcon = voicemail => {
  if (voicemail.sms_sent) {
    return 'fa-check-circle';
  } else if (voicemail.transcription_processed) {
    return 'fa-file-text';
  } else {
    return 'fa-clock';
  }
};

const openQuoteDrawer = quote => {
  selectedQuote.value = quote;
  showDrawer.value = true;
};

const closeDrawer = () => {
  showDrawer.value = false;
  selectedQuote.value = null;

  router.visit(route('quotes.index'));
};

const openVoicemailDrawer = voicemail => {
  selectedVoicemail.value = voicemail;
  showVoicemailDrawer.value = true;
};

const closeVoicemailDrawer = () => {
  showVoicemailDrawer.value = false;
  selectedVoicemail.value = null;
};
</script>

<template>
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4 lg:mb-6 bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
      <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <!-- SMS Stats Cards -->
    <div class="mb-4">
      <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
        <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-blue-600" />
        SMS Communications
      </h2>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6">
        <!-- New Inquiries -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
          <div class="flex items-center">
            <div
              class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0"
            >
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
            <div
              class="w-10 h-10 lg:w-12 lg:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0"
            >
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
            <div
              class="w-10 h-10 lg:w-12 lg:h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0"
            >
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
            <div
              class="w-10 h-10 lg:w-12 lg:h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0"
            >
              <font-awesome-icon :icon="['fas', 'fa-dollar-sign']" class="text-orange-600 text-sm lg:text-lg" />
            </div>
            <div class="ml-3 lg:ml-4 min-w-0">
              <p class="text-xs lg:text-sm font-medium text-gray-500">Est. Value</p>
              <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ stats.estimated_value }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Voicemail Stats Cards -->
    <div class="mb-6 lg:mb-8">
      <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
        <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-purple-600" />
        Voice Communications
      </h2>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6">
        <!-- Today Voicemails -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
          <div class="flex items-center">
            <div
              class="w-10 h-10 lg:w-12 lg:h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0"
            >
              <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-purple-600 text-sm lg:text-lg" />
            </div>
            <div class="ml-3 lg:ml-4 min-w-0">
              <p class="text-xs lg:text-sm font-medium text-gray-500">Today</p>
              <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ voicemail_stats.today_voicemails }}</p>
            </div>
          </div>
        </div>

        <!-- Total Voicemails -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
          <div class="flex items-center">
            <div
              class="w-10 h-10 lg:w-12 lg:h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0"
            >
              <font-awesome-icon :icon="['fas', 'fa-phone-alt']" class="text-indigo-600 text-sm lg:text-lg" />
            </div>
            <div class="ml-3 lg:ml-4 min-w-0">
              <p class="text-xs lg:text-sm font-medium text-gray-500">Total</p>
              <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ voicemail_stats.total_voicemails }}</p>
            </div>
          </div>
        </div>

        <!-- Transcribed Today -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
          <div class="flex items-center">
            <div
              class="w-10 h-10 lg:w-12 lg:h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0"
            >
              <font-awesome-icon :icon="['fas', 'fa-file-text']" class="text-teal-600 text-sm lg:text-lg" />
            </div>
            <div class="ml-3 lg:ml-4 min-w-0">
              <p class="text-xs lg:text-sm font-medium text-gray-500">Transcribed</p>
              <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ voicemail_stats.transcribed_today }}</p>
            </div>
          </div>
        </div>

        <!-- Responses Sent -->
        <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
          <div class="flex items-center">
            <div
              class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0"
            >
              <font-awesome-icon :icon="['fas', 'fa-paper-plane']" class="text-emerald-600 text-sm lg:text-lg" />
            </div>
            <div class="ml-3 lg:ml-4 min-w-0">
              <p class="text-xs lg:text-sm font-medium text-gray-500">Responded</p>
              <p class="text-lg lg:text-2xl font-semibold text-gray-900">{{ voicemail_stats.responses_sent_today }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Messages Card -->
    <div class="bg-white rounded-xl shadow-sm border-0 overflow-hidden">
      <!-- Header -->
      <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col gap-4">
          <h2 class="text-lg font-semibold text-gray-900">Recent Messages</h2>
        </div>
      </div>

      <!-- Desktop Table -->
      <div class="hidden lg:block px-6 py-4">
        <div class="overflow-x-auto">
          <template v-if="quotes.length === 0">
            <div class="flex flex-col items-center justify-center py-16">
              <font-awesome-icon :icon="['fas', 'fa-inbox']" class="text-gray-200 text-6xl mb-4" />
              <h3 class="text-lg font-semibold text-gray-700 mb-1">No Messages Yet</h3>
              <p class="text-gray-400 text-sm mb-2">You haven't received any messages from clients yet.</p>
              <p class="text-gray-300 text-xs">New messages will appear here as soon as you receive them.</p>
            </div>
          </template>
          <table v-else class="min-w-full">
            <thead>
              <tr class="border-b border-gray-200">
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-28">
                  Status
                </th>
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-40">
                  From
                </th>
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Client Message
                </th>
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                  AI Reply Preview
                </th>
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                  Time
                </th>
                <th class="text-right py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="quote in quotes" :key="quote.id" class="hover:bg-gray-50">
                <td class="py-5 px-4">
                  <span
                    class="px-3 py-1 rounded-full text-xs font-medium capitalize"
                    :class="getStatusBadgeClass(quote.status)"
                  >
                    <font-awesome-icon :icon="['fas', getStatusIcon(quote.status)]" class="mr-1" />
                    {{ quote.status }}
                  </span>
                </td>

                <td class="py-5 px-4 text-sm text-gray-900">
                  <span class="font-medium">{{ quote.from_number }}</span>
                </td>

                <td class="py-5 px-4 text-sm text-gray-900">
                  <div class="line-clamp-2 leading-relaxed">{{ quote.message }}</div>
                </td>

                <td class="py-5 px-4 text-sm text-gray-600">
                  <div v-if="quote.ai_response" class="line-clamp-2 leading-relaxed">{{ quote.ai_response }}</div>
                  <div v-else class="italic text-gray-400">No response yet</div>
                </td>

                <td class="py-5 px-4 text-sm text-gray-500">
                  {{ quote.created_at }}
                </td>

                <!-- Actions -->
                <td class="py-5 px-4 text-right">
                  <button
                    @click="openQuoteDrawer(quote)"
                    class="text-blue-600 hover:text-blue-700 text-sm font-medium cursor-pointer flex items-center gap-1 ml-auto"
                  >
                    <font-awesome-icon :icon="['fas', 'fa-eye']" />
                    View
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Mobile Cards -->
      <div class="lg:hidden">
        <div v-if="quotes.length === 0" class="flex flex-col items-center justify-center py-16">
          <font-awesome-icon :icon="['fas', 'fa-inbox']" class="text-gray-200 text-6xl mb-4" />
          <h3 class="text-lg font-semibold text-gray-700 mb-1">No Messages Yet</h3>
          <p class="text-gray-400 text-sm mb-2">You haven't received any messages from clients yet.</p>
          <p class="text-gray-300 text-xs">New messages will appear here as soon as you receive them.</p>
        </div>
        <div v-else class="divide-y divide-gray-200">
          <div
            v-for="quote in quotes"
            :key="quote.id"
            class="px-4 py-5 hover:bg-gray-50 cursor-pointer"
            @click="openQuoteDrawer(quote)"
          >
            <div class="flex items-start justify-between mb-4">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <span
                  class="px-3 py-1 rounded-full text-xs font-medium flex-shrink-0 capitalize"
                  :class="getStatusBadgeClass(quote.status)"
                >
                  <font-awesome-icon :icon="['fas', getStatusIcon(quote.status)]" class="mr-1" />
                  {{ quote.status }}
                </span>
                <span class="text-sm font-medium text-gray-900 truncate">{{ quote.from_number }}</span>
              </div>
              <span class="text-xs text-gray-500 flex-shrink-0 ml-2">{{ quote.created_at }}</span>
            </div>

            <div class="space-y-4">
              <div>
                <p class="text-xs font-medium text-gray-500 mb-2">Client Message</p>
                <p class="text-sm text-gray-900 leading-relaxed overflow-hidden line-clamp-3">{{ quote.message }}</p>
              </div>

              <div v-if="quote.ai_response">
                <p class="text-xs font-medium text-gray-500 mb-2">AI Reply Preview</p>
                <p class="text-sm text-gray-600 leading-relaxed overflow-hidden line-clamp-3">
                  {{ quote.ai_response }}
                </p>
              </div>

              <div v-else class="text-sm text-center text-gray-400 italic">-</div>
            </div>

            <div class="flex justify-end mt-4 pt-2">
              <button
                @click.stop="openQuoteDrawer(quote)"
                class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1"
              >
                <font-awesome-icon :icon="['fas', 'fa-eye']" />
                View Details →
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Voicemail Card -->
    <div class="bg-white rounded-xl shadow-sm border-0 overflow-hidden mt-6 lg:mt-8">
      <!-- Header -->
      <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
          <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-purple-600" />
          Recent Voicemails
        </h2>
      </div>

      <!-- Desktop Table -->
      <div class="hidden lg:block px-6 py-4">
        <div class="overflow-x-auto">
          <template v-if="voicemails.length === 0">
            <div class="flex flex-col items-center justify-center py-16">
              <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-purple-100 text-6xl mb-4" />
              <h3 class="text-lg font-semibold text-gray-700 mb-1">No Voicemails Yet</h3>
              <p class="text-gray-400 text-sm mb-2">You haven't received any voicemails yet.</p>
              <p class="text-gray-300 text-xs">New voicemails will appear here as soon as they are received.</p>
            </div>
          </template>
          <table v-else class="min-w-full">
            <thead>
              <tr class="border-b border-gray-200">
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                  Status
                </th>
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-44">
                  From
                </th>
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
                  Duration
                </th>
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Transcript
                </th>
                <th class="text-left py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                  Time
                </th>
                <th class="text-right py-4 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider w-40">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="voicemail in voicemails" :key="voicemail.id" class="hover:bg-gray-50">
                <td class="py-5 px-4">
                  <span
                    class="px-3 py-1 rounded-full text-xs font-medium"
                    :class="getVoicemailStatusBadgeClass(voicemail)"
                  >
                    <font-awesome-icon :icon="['fas', getVoicemailStatusIcon(voicemail)]" class="mr-1" />
                    {{ getVoicemailStatusText(voicemail) }}
                  </span>
                </td>

                <td class="py-5 px-4 text-sm text-gray-900">
                  <div class="flex flex-col gap-1">
                    <span class="font-medium">{{ voicemail.from_number }}</span>
                  </div>
                </td>

                <td class="py-5 px-4 text-sm text-gray-900">
                  <div class="flex items-center gap-1">
                    <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-gray-400 text-xs" />
                    <span class="font-mono text-xs">{{ formatDuration(voicemail.recording_duration) }}</span>
                  </div>
                </td>

                <td class="py-5 px-4 text-sm text-gray-600">
                  <div v-if="voicemail.transcription_text" class="line-clamp-2 leading-relaxed">
                    {{ voicemail.transcription_text }}
                  </div>
                  <div v-else class="italic text-gray-400">Processing transcript...</div>
                </td>

                <td class="py-5 px-4 text-sm text-gray-500">
                  {{ voicemail.created_at }}
                </td>

                <!-- Actions -->
                <td class="py-5 px-4 text-right">
                  <div class="flex justify-between">
                    <button
                      class="text-purple-600 hover:text-purple-700 text-sm font-medium cursor-pointer flex items-center gap-1 mr-auto"
                      @click="openVoicemailDrawer(voicemail)"
                    >
                      <font-awesome-icon :icon="['fas', 'fa-play']" />
                      Play
                    </button>
                    <button
                      class="text-blue-600 hover:text-blue-700 text-sm font-medium cursor-pointer flex items-center gap-1 ml-auto"
                      @click="openVoicemailDrawer(voicemail)"
                    >
                      <font-awesome-icon :icon="['fas', 'fa-eye']" />
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
      <div class="lg:hidden divide-y divide-gray-200">
        <template v-if="voicemails.length === 0">
          <div class="flex flex-col items-center justify-center py-16">
            <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-purple-100 text-6xl mb-4" />
            <h3 class="text-lg font-semibold text-gray-700 mb-1">No Voicemails Yet</h3>
            <p class="text-gray-400 text-sm text-center leading-snug mt-4 mb-2 max-w-xs mx-auto">
              New voicemails will appear here as soon as they are received.
            </p>
          </div>
        </template>
        <template v-else>
          <div v-for="voicemail in voicemails" :key="voicemail.id" class="px-4 py-5 hover:bg-gray-50">
            <div class="flex items-start justify-between mb-4">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <span
                  class="px-3 py-1 rounded-full text-xs font-medium flex-shrink-0"
                  :class="getVoicemailStatusBadgeClass(voicemail)"
                >
                  <font-awesome-icon :icon="['fas', getVoicemailStatusIcon(voicemail)]" class="mr-1" />
                  {{ getVoicemailStatusText(voicemail) }}
                </span>
                <span class="text-sm font-medium text-gray-900 truncate">{{ voicemail.from_number }}</span>
              </div>
              <span class="text-xs text-gray-500 flex-shrink-0 ml-2">{{ voicemail.created_at }}</span>
            </div>

            <div class="space-y-4">
              <div class="flex items-center gap-2 text-sm text-gray-600">
                <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-gray-400 text-xs" />
                <span class="font-mono">Duration: {{ formatDuration(voicemail.recording_duration) }}</span>
              </div>

              <div v-if="voicemail.transcription_text">
                <p class="text-xs font-medium text-gray-500 mb-2">Transcript Preview</p>
                <p
                  class="text-sm text-gray-900 leading-relaxed overflow-hidden"
                  style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical"
                >
                  {{ voicemail.transcription_text }}
                </p>
              </div>

              <div v-else class="text-sm text-gray-400 italic">Transcript processing...</div>
            </div>

            <div class="flex justify-end mt-4 pt-2">
              <button
                @click="openVoicemailDrawer(voicemail)"
                class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1"
              >
                <font-awesome-icon :icon="['fas', 'fa-eye']" />
                View Details →
              </button>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>

  <!-- Quote Drawer -->
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

  <!-- Voicemail Drawer -->
  <Drawer
    v-model:visible="showVoicemailDrawer"
    position="right"
    :modal="true"
    :dismissableMask="true"
    :style="{ width: '480px' }"
    class="lg:block"
  >
    <template #header>
      <div class="flex flex-col w-full py-2 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Voicemail Details</h2>
        <p class="text-sm text-gray-500 mt-1">Review voicemail and transcript</p>
      </div>
    </template>

    <ShowVoicemail :voicemail="selectedVoicemail" @cancel="closeVoicemailDrawer" />
  </Drawer>
</template>
