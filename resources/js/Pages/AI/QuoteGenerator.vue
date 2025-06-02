<script setup>
import { ref, computed } from 'vue';
import Layout from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';

defineOptions({
  layout: Layout,
});

// Form data
const form = ref({
  clientMessage: '',
  location: '',
  jobType: ''
});

// AI Response state
const aiResponse = ref('');
const isGenerating = ref(false);
const isEditing = ref(false);
const editedResponse = ref('');

// Job type options
const jobTypes = ref([
  { label: 'Electrical', value: 'electrical' },
  { label: 'Plumbing', value: 'plumbing' },
  { label: 'General Maintenance', value: 'general' },
  { label: 'HVAC', value: 'hvac' },
  { label: 'Carpentry', value: 'carpentry' }
]);

// Generate AI response
const generateResponse = async () => {
  if (!form.value.clientMessage.trim() || !form.value.jobType) return;
  
  isGenerating.value = true;
  aiResponse.value = '';
  
  try {
    // Replace with actual API call to your Laravel backend
    const response = await fetch('/api/quotes/generate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        client_message: form.value.clientMessage,
        location: form.value.location,
        job_type: form.value.jobType
      })
    });
    
    const data = await response.json();
    aiResponse.value = data.response;
    editedResponse.value = data.response;
  } catch (error) {
    console.error('Error generating response:', error);
    // Show error toast
  } finally {
    isGenerating.value = false;
  }
};

// Toggle edit mode
const toggleEdit = () => {
  isEditing.value = !isEditing.value;
  if (!isEditing.value) {
    aiResponse.value = editedResponse.value;
  }
};

// Save edited response
const saveResponse = async () => {
  try {
    // Save to backend
    aiResponse.value = editedResponse.value;
    isEditing.value = false;
    // Show success toast
  } catch (error) {
    console.error('Error saving response:', error);
  }
};

// Send response actions
const sendResponse = async (method) => {
  try {
    // Send via SMS or Email
    const response = await fetch(`/api/quotes/send-${method}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        response: aiResponse.value,
        client_message: form.value.clientMessage,
        location: form.value.location,
        job_type: form.value.jobType
      })
    });
    
    if (response.ok) {
      // Show success message
      console.log(`Sent via ${method}`);
    }
  } catch (error) {
    console.error(`Error sending via ${method}:`, error);
  }
};

const characterCount = computed(() => aiResponse.value.length);
</script>

<template>
  <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6 bg-white rounded-xl shadow-sm border-0 p-6">
      <h1 class="text-2xl font-bold text-gray-900">AI Quote Generator</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Left Column - Quote Request Details -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900">Quote Request Details</h2>
          <p class="text-sm text-gray-600 mt-1">Enter the client's message and job details to generate an AI response.</p>
        </div>

        <div class="space-y-6">
          <!-- Client Message -->
          <div>
            <label for="clientMessage" class="block text-sm font-medium text-gray-700 mb-2">
              Client Message <span class="text-red-500">*</span>
            </label>
            <textarea
              id="clientMessage"
              v-model="form.clientMessage"
              rows="6"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
              placeholder="Enter the client's inquiry or message..."
              required
            ></textarea>
          </div>

          <!-- Generate Button -->
          <Button
            @click="generateResponse"
            label="Generate AI Reply"
            :disabled="isGenerating || !form.clientMessage.trim()"
            :icon="['fas', 'fa-bolt']"
            class="w-full justify-center"
          />
        </div>
      </div>

      <!-- Right Column - AI Generated Response -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900">AI Generated Response</h2>
          <p class="text-sm text-gray-600 mt-1">Review and edit the AI response before sending to your client.</p>
        </div>

        <!-- Empty State -->
        <div v-if="!aiResponse && !isGenerating" class="flex flex-col items-center justify-center py-16 text-center">
          <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <font-awesome-icon :icon="['fas', 'fa-bolt']" class="text-gray-400 text-xl" />
          </div>
          <p class="text-gray-500">Generate an AI response to see it here</p>
        </div>

        <!-- Loading State -->
        <div v-else-if="isGenerating" class="flex flex-col items-center justify-center py-16">
          <div class="w-8 h-8 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mb-4"></div>
          <p class="text-gray-600">Generating AI response...</p>
        </div>

        <!-- Generated Response -->
        <div v-else class="space-y-4">
          <!-- Response Content -->
          <div class="bg-gray-50 rounded-lg p-4 min-h-[200px]">
            <div v-if="!isEditing" class="whitespace-pre-wrap text-gray-900 leading-relaxed">
              {{ aiResponse }}
            </div>
            <textarea
              v-else
              v-model="editedResponse"
              rows="8"
              class="w-full bg-white border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
            ></textarea>
          </div>

          <!-- Character Count -->
          <div class="flex justify-between items-center text-sm text-gray-500">
            <span>{{ characterCount }} characters</span>
            <span v-if="characterCount > 160" class="text-orange-600">
              <font-awesome-icon :icon="['fas', 'fa-exclamation-triangle']" class="mr-1" />
              SMS will be split into {{ Math.ceil(characterCount / 160) }} messages
            </span>
          </div>

          <!-- Action Buttons -->
          <div class="space-y-3">
            <!-- Edit Controls -->
            <div v-if="isEditing" class="flex gap-2">
              <Button
                @click="saveResponse"
                :icon="['fas', 'fa-check']"
                class="flex-1 bg-green-600 hover:bg-green-700 text-white"
              >
                Save Changes
              </Button>
              <Button
                @click="toggleEdit"
                :icon="['fas', 'fa-times']"
                outlined
                class="flex-1"
              >
                Cancel
              </Button>
            </div>

            <!-- Main Actions -->
            <div v-else class="space-y-2">
              <Button
                @click="toggleEdit"
                :icon="['fas', 'fa-edit']"
                outlined
                class="w-full"
              >
                Edit Response
              </Button>
              
              <div class="grid grid-cols-2 gap-2">
                <Button
                  @click="sendResponse('sms')"
                  :icon="['fas', 'fa-sms']"
                  class="bg-green-600 hover:bg-green-700 text-white"
                >
                  Send SMS
                </Button>
                <Button
                  @click="sendResponse('email')"
                  :icon="['fas', 'fa-envelope']"
                  class="bg-blue-600 hover:bg-blue-700 text-white"
                >
                  Send Email
                </Button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>