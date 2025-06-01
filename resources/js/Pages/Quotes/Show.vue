
<script setup>
import { ref, computed } from 'vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import TextArea from '@/Shared/Ui/Form/TextArea.vue';
import { useToast } from '@/Shared/Ui/Hooks/useToast';

const { showToast } = useToast();

const props = defineProps({
  quote: Object
});

const emit = defineEmits(['success', 'cancel']);

// Edit mode state
const isEditing = ref(false);
const isSaving = ref(false);
const isSending = ref(false);
const editedResponse = ref('');

const startEditing = () => {
  isEditing.value = true;
  editedResponse.value = props.quote.edited_response || props.quote.ai_response;
};

const cancelEditing = () => {
  isEditing.value = false;
  editedResponse.value = '';
};

const onClickSave = async () => {
  isSaving.value = true;
  try {
    isEditing.value = false;

    await axios.put(route('quotes.update', props.quote.id), {
      _method: 'PUT',
      edited_response: editedResponse.value,
    }).then(() => {
      showToast('success', 'Quote updated successfully');
    }).catch(() => {
      showToast('error', 'Error updating quote');
    });
  } catch (error) {
    emit('error');
    showToast('error', 'Error updating quote');
  } finally {
    isSaving.value = false;
  }
};

const onClickSend = async () => {
  isSending.value = true;
  
  try {
    await axios.post(route('quotes.send', props.quote.id)).then(() => {
      showToast('success', 'Quote sent successfully');
    }).catch(() => {
      showToast('error', 'Error sending quote');
    });

    emit('success');
  } catch (error) {
    emit('error');
    showToast('error', 'Error sending quote');
  } finally {
    isSending.value = false;
  }

};

const currentResponse = computed(() => {
  return props.quote.edited_response || props.quote.ai_response;
});

</script>
<template>
  <div class="h-full bg-gray-50">
    <!-- Content -->
    <div class="p-4 space-y-4 h-full overflow-y-auto">

      <!-- Timeline Info -->
      <div class="bg-white rounded-xl shadow-sm p-5 border-0">
        <h3 class="text-sm font-medium text-gray-900 mb-4 flex items-center gap-2">
          <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-gray-400" />
          Timeline
        </h3>
        
        <div class="space-y-3">
          <div class="flex items-center gap-3 text-sm">
            <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
            <span class="text-gray-600">From:</span>
            <span class="text-gray-900 font-medium">{{ quote.from_number }}</span>
          </div>

          <div class="flex items-center gap-3 text-sm">
            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
            <span class="text-gray-600">Received:</span>
            <span class="text-gray-900 font-medium">{{ new Date(quote.created_at).toLocaleString('en-AU') }}</span>
          </div>
          
          <div v-if="quote.sent_at" class="flex items-center gap-3 text-sm">
            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
            <span class="text-gray-600">Sent:</span>
            <span class="text-gray-900 font-medium">{{ new Date(quote.sent_at).toLocaleString('en-AU') }}</span>
          </div>
        </div>
      </div>

      <!-- Status and Meta Info -->
      <div class="bg-white rounded-xl shadow-sm p-5 border-0">
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center gap-3">
            <!-- Status Badge -->
            <span
              class="px-3 py-1 rounded-full text-xs font-medium"
              :class="{
                'bg-green-100 text-green-700': quote.status === 'sent',
                'bg-yellow-100 text-yellow-700': quote.status === 'pending',
                'bg-red-100 text-red-700': quote.status === 'rejected',
              }"
            >
              <font-awesome-icon 
                :icon="['fas', quote.status === 'sent' ? 'fa-check-circle' : quote.status === 'pending' ? 'fa-clock' : 'fa-times-circle']" 
                class="mr-1.5"
              />
              {{ quote.status }}
            </span>
          </div>
          <!-- Quote ID -->
          <span class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-md">
            <font-awesome-icon :icon="['fas', 'fa-hashtag']" class="mr-1" />
            Quote {{ quote.id }}
          </span>
        </div>
        <!-- Conversation -->
        <div class="space-y-6">
          <!-- Client Message -->
          <div>
            <h3 class="text-sm font-medium text-gray-900 mb-3 flex items-center gap-2">
              <font-awesome-icon :icon="['fas', 'fa-user']" class="text-gray-400" />
              Client Message
            </h3>
            <div class="bg-gray-50 rounded-2xl rounded-tl-sm p-4">
              <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ quote.message }}</p>
            </div>
          </div>
          <!-- Your Response -->
          <div>
            <div class="flex items-center justify-between mb-3">
              <h3 class="text-sm font-medium text-gray-900 flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-blue-500" />
                Your Response
                <span v-if="quote.edited_response" class="text-xs text-gray-500">
                  edited
                </span>
              </h3>
              
              <!-- Edit Toggle -->
              <button
                v-if="!isEditing && quote.status !== 'sent'"
                @click="startEditing"
                class="text-xs text-blue-600 hover:text-blue-700 flex items-center gap-1 cursor-pointer"
              >
                <font-awesome-icon :icon="['fas', 'fa-pencil']" />
                Edit
              </button>
            </div>
            <!-- View Mode -->
            <div v-if="!isEditing" class="bg-blue-50 rounded-2xl rounded-tr-sm p-4 border border-blue-100">
              <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ currentResponse }}</p>
            </div>
            <!-- Edit Mode -->
            <div v-else class="space-y-3">
              <TextArea
                  id="edited_response"
                  v-model="editedResponse"
                  rows="3"
                  class="w-full min-h-[120px] p-4 rounded-2xl rounded-tr-sm resize-none focus:outline-none focus:border-yellow-300"
              />
              
              <!-- Edit Actions -->
              <div class="flex gap-2 justify-end">
                <Button
                  @click="cancelEditing"
                  label="Cancel"
                  size="small"
                  outlined
                />
                <Button
                  @click="onClickSave"
                  :disabled="isSaving"
                  label="Update"
                  size="small"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sticky Footer Actions -->
    <div class="border-t border-gray-200 bg-white p-4">
      <div class="flex gap-3">
        <!-- Back Button -->
        <Button
          label="Back"
          @click="emit('cancel')"
          outlined
          size="small"
          :icon="['fas', 'fa-arrow-left']"
          class="flex-1"
        />
        <Button
          v-if="quote.status === 'pending'"
          @click="onClickSend"
          :disabled="isSending || isEditing"
          size="small"
          :icon="['fas', 'fa-paper-plane']"
          class="flex-1"
          :label="isSending ? 'Sending...' : 'Send Quote'"
        />
      </div>
    </div>
  </div>
</template>