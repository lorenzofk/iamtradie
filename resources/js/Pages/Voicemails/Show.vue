<script setup>
import { ref, computed } from 'vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import { useToast } from '@/Shared/Ui/Hooks/useToast';

const { showToast } = useToast();

const props = defineProps({
  voicemail: Object,
});

const emit = defineEmits(['success', 'cancel']);

// Audio playback state
const currentAudio = ref(null);
const playingVoicemailId = ref(null);

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

const toggleAudio = voicemail => {
  if (!voicemail.recording_url) return;

  // If this voicemail is currently playing, pause it
  if (playingVoicemailId.value === voicemail.id && currentAudio.value) {
    currentAudio.value.pause();
    currentAudio.value = null;
    playingVoicemailId.value = null;
    return;
  }

  // Stop any currently playing audio
  if (currentAudio.value) {
    currentAudio.value.pause();
    currentAudio.value = null;
  }

  // Start playing the new audio
  try {
    const audio = new Audio(voicemail.recording_url);
    currentAudio.value = audio;
    playingVoicemailId.value = voicemail.id;

    audio.addEventListener('ended', () => {
      currentAudio.value = null;
      playingVoicemailId.value = null;
    });

    audio.addEventListener('error', error => {
      console.error('Error playing audio:', error);
      currentAudio.value = null;
      playingVoicemailId.value = null;
    });

    audio.play();
  } catch (error) {
    console.error('Error creating audio:', error);
    currentAudio.value = null;
    playingVoicemailId.value = null;
  }
};

const isPlaying = voicemailId => {
  return playingVoicemailId.value === voicemailId;
};

const handleClose = () => {
  // Stop any playing audio when closing
  if (currentAudio.value) {
    currentAudio.value.pause();
    currentAudio.value = null;
    playingVoicemailId.value = null;
  }
  emit('cancel');
};
</script>

<template>
  <div class="h-full bg-gray-50">
    <!-- Content -->
    <div class="p-3 lg:p-4 space-y-3 lg:space-y-4 h-full overflow-y-auto">
      <!-- Timeline Info -->
      <div class="bg-white rounded-xl shadow-sm p-4 lg:p-5 border-0">
        <h3 class="text-sm font-medium text-gray-900 mb-3 lg:mb-4 flex items-center gap-2">
          <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-gray-400" />
          Timeline
        </h3>

        <div class="space-y-2 lg:space-y-3">
          <div class="flex items-start gap-3 text-sm">
            <div class="w-2 h-2 bg-gray-400 rounded-full flex-shrink-0 mt-2"></div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
              <span class="text-gray-600 text-xs sm:text-sm">From:</span>
              <span class="text-gray-900 font-medium text-sm break-all">{{ voicemail.from_number }}</span>
            </div>
          </div>

          <div class="flex items-start gap-3 text-sm">
            <div class="w-2 h-2 bg-purple-500 rounded-full flex-shrink-0 mt-2"></div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
              <span class="text-gray-600 text-xs sm:text-sm">Received:</span>
              <span class="text-gray-900 font-medium text-sm">
                {{ new Date(voicemail.created_at).toLocaleString('en-AU') }}
              </span>
            </div>
          </div>

          <div v-if="voicemail.sms_sent_at" class="flex items-start gap-3 text-sm">
            <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0 mt-2"></div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
              <span class="text-gray-600 text-xs sm:text-sm">Responded:</span>
              <span class="text-gray-900 font-medium text-sm">
                {{ new Date(voicemail.sms_sent_at).toLocaleString('en-AU') }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Status and Meta Info -->
      <div class="bg-white rounded-xl shadow-sm p-4 lg:p-5 border-0">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">
          <div class="flex items-center gap-3">
            <!-- Status Badge -->
            <span
              class="px-2 lg:px-3 py-1 rounded-full text-xs font-medium flex-shrink-0"
              :class="getVoicemailStatusBadgeClass(voicemail)"
            >
              <font-awesome-icon :icon="['fas', getVoicemailStatusIcon(voicemail)]" class="mr-1.5" />
              {{ getVoicemailStatusText(voicemail) }}
            </span>
          </div>

          <!-- Voicemail ID -->
          <span class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-md flex-shrink-0">
            <font-awesome-icon :icon="['fas', 'fa-hashtag']" class="mr-1" />
            Voicemail {{ voicemail.id }}
          </span>
        </div>

        <!-- Voicemail Details -->
        <div class="space-y-4 lg:space-y-6">
          <!-- Audio Player -->
          <div v-if="voicemail.recording_url" class="bg-purple-50 rounded-2xl p-4 lg:p-5 border border-purple-100">
            <h3 class="text-sm font-medium text-gray-900 mb-3 lg:mb-4 flex items-center gap-2">
              <font-awesome-icon :icon="['fas', 'fa-volume-up']" class="text-purple-500" />
              Audio Recording
            </h3>
            <div class="flex items-center gap-4">
              <button
                @click="toggleAudio(voicemail)"
                class="flex items-center gap-3 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors"
              >
                <font-awesome-icon :icon="['fas', isPlaying(voicemail.id) ? 'fa-pause' : 'fa-play']" />
                {{ isPlaying(voicemail.id) ? 'Pause Audio' : 'Play Audio' }}
              </button>
              <div class="flex items-center gap-2 text-sm text-gray-600">
                <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-gray-400" />
                <span class="font-mono">{{ formatDuration(voicemail.recording_duration) }}</span>
              </div>
            </div>
          </div>

          <!-- Transcript -->
          <div v-if="voicemail.transcription_processed && voicemail.transcription_text">
            <h3 class="text-sm font-medium text-gray-900 mb-2 lg:mb-3 flex items-center gap-2">
              <font-awesome-icon :icon="['fas', 'fa-file-text']" class="text-blue-500" />
              Transcript
            </h3>
            <div class="bg-gray-50 rounded-2xl p-3 lg:p-4">
              <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm lg:text-base">
                {{ voicemail.transcription_text }}
              </p>
            </div>
          </div>

          <div v-else-if="!voicemail.transcription_processed">
            <h3 class="text-sm font-medium text-gray-900 mb-2 lg:mb-3 flex items-center gap-2">
              <font-awesome-icon :icon="['fas', 'fa-file-text']" class="text-gray-400" />
              Transcript
            </h3>
            <div class="bg-yellow-50 rounded-2xl p-3 lg:p-4 border border-yellow-100">
              <div class="flex items-center gap-2 text-yellow-800">
                <font-awesome-icon :icon="['fas', 'fa-clock']" class="animate-spin" />
                <span class="text-sm">Processing transcript...</span>
              </div>
            </div>
          </div>

          <!-- AI Response -->
          <div v-if="voicemail.ai_response">
            <h3 class="text-sm font-medium text-gray-900 mb-2 lg:mb-3 flex items-center gap-2">
              <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-blue-500" />
              AI Response
            </h3>
            <div class="bg-blue-50 rounded-2xl p-3 lg:p-4 border border-blue-100">
              <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm lg:text-base">
                {{ voicemail.ai_response }}
              </p>
            </div>
          </div>

          <!-- SMS Status -->
          <div v-if="voicemail.sms_sent">
            <h3 class="text-sm font-medium text-gray-900 mb-2 lg:mb-3 flex items-center gap-2">
              <font-awesome-icon :icon="['fas', 'fa-paper-plane']" class="text-green-500" />
              SMS Response
            </h3>
            <div class="bg-green-50 rounded-2xl p-3 lg:p-4 border border-green-100">
              <div class="flex items-center gap-2 text-green-800 mb-2">
                <font-awesome-icon :icon="['fas', 'fa-check-circle']" />
                <span class="text-sm font-medium">SMS sent successfully</span>
              </div>
              <p class="text-xs text-green-600">
                Sent on {{ new Date(voicemail.sms_sent_at).toLocaleString('en-AU') }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sticky Footer Actions -->
    <div class="border-t border-gray-200 bg-white p-3 lg:p-4">
      <div class="flex flex-col sm:flex-row gap-2 lg:gap-3">
        <!-- Back Button -->
        <Button
          label="Back"
          @click="handleClose"
          outlined
          size="small"
          :icon="['fas', 'fa-arrow-left']"
          class="flex-1"
        />
      </div>
    </div>
  </div>
</template>
