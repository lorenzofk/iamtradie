<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import Layout from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import FormElement from '@/Shared/Ui/Form/FormElement.vue';
import FormLabel from '@/Shared/Ui/Form/FormLabel.vue';
import Select from '@/Shared/Ui/Form/Select.vue';
import ToggleSwitch from '@/Shared/Ui/Form/ToggleSwitch.vue';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import TextArea from '@/Shared/Ui/Form/TextArea.vue';
import InputNumber from '@/Shared/Ui/Form/InputNumber.vue';

const { showToast } = useToast();

defineOptions({
  layout: Layout,
});

const props = defineProps({
  settings: Object,
  sms_data: Object,
  response_tones: Object
});

const form = useForm('post', route('settings.communication.update'), {
  response_tone: props.settings?.response_tone || 'casual',
  auto_send_sms: props.settings?.auto_send_sms || false,
  call_forward_enabled: props.settings?.call_forward_enabled || false,
  call_ring_duration: props.settings?.call_ring_duration || 20,
  auto_send_sms_after_voicemail: props.settings?.auto_send_sms_after_voicemail || false,
  voicemail_message: props.settings?.voicemail_message || "Hi, I'm not available right now. Please leave a message and I'll get back to you with a quote.",
});

const onFormSubmit = () => {  
  form.submit({
    preserveScroll: true,
    onSuccess: () => {
      showToast('success', 'Communication settings updated successfully.');
    },
    onError: error => {
      showToast('error', error.message);
    },
  });
};

const copyPhoneNumber = () => {
  navigator.clipboard.writeText(props.settings.agent_sms_number);
};
</script>

<template>
  <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6 bg-white rounded-xl shadow-sm border-0 p-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Communication Hub</h1>
        <p class="text-sm text-gray-600 mt-1">Manage your SMS and voice communication settings</p>
      </div>
      <div>
        <div class="flex items-center gap-2">
          <div class="w-4 h-4 bg-gray-100 rounded-full flex items-center justify-center">
            <font-awesome-icon :icon="['fas', 'fa-chart-line']" class="text-gray-600 text-sm" />
          </div>
          <div class="text-sm">
            <span class="font-medium text-gray-900">{{ props.sms_data?.quotes_used || 0 }}</span>
            <span class="text-gray-500"> / {{ props.sms_data?.quotes_limit }} quotes used</span>
          </div>
        </div>
        <!-- Progress Bar -->
        <div class="mt-1 w-full h-1 bg-gray-200 rounded-full overflow-hidden">
          <div class="h-full bg-blue-500 rounded-full transition-all duration-300" :style="{ width: `${((props.sms_data?.quotes_used || 0) / props.sms_data?.quotes_limit) * 100}%` }"></div>
        </div>
      </div>
    </div>
    
    <div class="space-y-8">
      <!-- Phone Number Section -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-blue-600" />
            Your Business Number
          </h2>
          <p class="text-sm text-gray-600 mt-1">Unified phone number for SMS and voice communications</p>
        </div>
        
        <!-- Active Number Display -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="text-green-600" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-900">Active Business Number</p>
              <p class="text-lg font-semibold text-green-800">{{ props.settings.agent_sms_number }}</p>
              <p class="text-xs text-green-700 mt-1">Handles both SMS and voice calls</p>
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

        <!-- Current Configuration Status -->
        <div class="pt-4 border-t border-gray-100">
          <h3 class="text-sm font-medium text-gray-900 mb-3">Current Configuration</h3>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-gray-600 text-sm" />
                <span class="text-sm text-gray-700">SMS Active</span>
              </div>
              <span class="text-xs font-medium text-green-700">On</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-phone-volume']" class="text-gray-600 text-sm" />
                <span class="text-sm text-gray-700">Call Handling</span>
              </div>
              <span class="text-xs font-medium text-gray-900">{{ form.call_forward_enabled ? 'Forward' : 'Voicemail' }}</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-dollar-sign']" class="text-gray-600 text-sm" />
                <span class="text-sm text-gray-700">Rates</span>
              </div>
              <span class="text-xs font-medium text-gray-900">${{ props.settings.callout_fee }} + ${{ props.settings.hourly_rate }}/hr</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-comment-dots']" class="text-gray-600 text-sm" />
                <span class="text-sm text-gray-700">AI Tone</span>
              </div>
              <span class="text-xs font-medium text-gray-900 capitalize">{{ props.settings.response_tone }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- SMS Workflow Section -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-blue-600" />
            SMS Workflow
          </h2>
          <p class="text-sm text-gray-600 mt-1">Automatic SMS quote generation and response system</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-6">
          <!-- Step 1 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 relative">
              <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-blue-600 text-xl" />
              <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</div>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-2">Customer Texts</h3>
            <p class="text-sm text-gray-600">Customer sends quote request to your number</p>
          </div>
          
          <!-- Step 2 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4 relative">
              <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-purple-600 text-xl" />
              <div class="absolute -top-2 -right-2 w-6 h-6 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</div>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-2">AI Generates Quote</h3>
            <p class="text-sm text-gray-600">System creates professional quote using your rates</p>
          </div>
          
          <!-- Step 3 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4 relative">
              <font-awesome-icon :icon="['fas', 'fa-paper-plane']" class="text-green-600 text-xl" />
              <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</div>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-2">Auto Response</h3>
            <p class="text-sm text-gray-600">Quote sent automatically or saved for review</p>
          </div>
        </div>

        <!-- Instructions -->
        <div class="text-sm text-gray-600 space-y-2">
          <p class="font-medium text-gray-900">How to use your SMS number:</p>
          <ol class="list-decimal list-inside space-y-1 ml-4">
            <li>Share this number with potential clients.</li>
            <li>They can text you directly for quotes.</li>
            <li>AI will generate responses automatically when you enable auto-send SMS.</li>
          </ol>
        </div>
      </div>

      <!-- AI Response Settings Section -->
      <form @submit.prevent="onFormSubmit" class="space-y-6">
        
        <div class="bg-white rounded-xl shadow-sm border-0 p-6">
          <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
              <font-awesome-icon :icon="['fas', 'fa-phone-volume']" class="text-orange-600" />
              Voice Call Workflow
            </h2>
            <p class="text-sm text-gray-600 mt-1">Handle incoming calls with forwarding or voicemail options.</p>
          </div>
          <div class="mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-6 bg-gray-50 rounded-lg">
              <!-- Step 1: Call Received -->
              <div class="text-center">
                <div class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2">
                  <font-awesome-icon :icon="['fas', 'fa-phone-alt']" class="text-gray-600 text-lg" />
                </div>
                <p class="text-sm font-medium text-gray-900">Call Received</p>
              </div>
              
              <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-400 hidden md:block" />
              
              <!-- Step 2: Decision Point -->
              <div class="text-center">
                <div class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2">
                  <div v-if="form.call_forward_enabled" class="flex items-center justify-center">
                    <font-awesome-icon :icon="['fas',  'fa-phone']" class="text-gray-600 text-lg" />  
                    <font-awesome-icon :icon="['fas',  'fa-arrow-right']" class="text-gray-600 text-lg" />
                  </div>
                  <font-awesome-icon v-else :icon="['fas',  'fa-phone-slash']" class="text-gray-600 text-lg" />
                </div>
                <p class="text-sm font-medium text-gray-900">{{ form.call_forward_enabled ? 'Forward Call' : 'Direct to VM' }}</p>
              </div>
              
              <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-400 hidden md:block" />
              
              <!-- Step 3: Voicemail -->
              <div class="text-center">
                <div class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2">
                  <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-gray-600 text-lg" />
                </div>
                <p class="text-sm font-medium text-gray-900">Voicemail</p>
              </div>
              
              <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-400 hidden md:block" />
              
              <!-- Step 4: Transcript -->
              <div class="text-center">
                <div class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2">
                  <font-awesome-icon :icon="['fas', 'fa-file-text']" class="text-gray-600 text-lg" />
                </div>
                <p class="text-sm font-medium text-gray-900">Transcript</p>
              </div>
              
              <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-400 hidden md:block" />
              
              <!-- Step 5: Summary + Optional Quote -->
              <div class="text-center">
                <div class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2">
                  <font-awesome-icon :icon="['fas', 'fa-clipboard-list']" class="text-gray-600 text-lg" />
                </div>
                <p class="text-sm font-medium text-gray-900">Summary + Quote</p>
              </div>
            </div>
          </div>
          <div class="space-y-6">
            <div class="space-y-4 pt-4">
              <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                  <h4 class="text-sm font-medium text-gray-900">Call Forwarding</h4>
                  <p class="text-sm text-gray-500">Forward calls to your business phone number</p>
                </div>
                <ToggleSwitch id="call_forward_enabled" v-model="form.call_forward_enabled" :error="form.errors.call_forward_enabled" />
              </div>
            </div>
            <div v-if="form.call_forward_enabled" class="space-y-4 pt-4">
              <FormElement>
                <FormLabel for="call_ring_duration">Ring duration before voicemail</FormLabel>
                <InputNumber id="call_ring_duration" v-model="form.call_ring_duration" :error="form.errors.call_ring_duration" />
              </FormElement>
            </div>
            <div class="space-y-4 pt-4">
              <FormElement>
                <FormLabel for="voicemail_message">Voicemail message</FormLabel>
                <TextArea id="voicemail_message" :rows="2" v-model="form.voicemail_message" :error="form.errors.voicemail_message" />
              </FormElement>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border-0 p-6">
          <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
              <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-purple-600" />
              AI Response Settings
            </h2>
            <p class="text-sm text-gray-600 mt-1">Configure how AI generates and sends quotes for both SMS and voice</p>
          </div>
          <div class="space-y-6">
            <FormElement>
              <FormLabel for="response_tone">Response Tone</FormLabel>
              <Select
                id="response_tone"
                v-model="form.response_tone"
                optionLabel="label"
                optionValue="id"
                :options="response_tones"
                :error="form.errors.response_tone"
                required
              />
            </FormElement>
            <div class="space-y-4 pt-4">
              <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                  <h4 class="text-sm font-medium text-gray-900">Auto-send SMS Quotes</h4>
                  <p class="text-sm text-gray-500">Automatically send AI responses via SMS when customers submit quotes</p>
                </div>
                <ToggleSwitch id="auto_send_sms" v-model="form.auto_send_sms" :error="form.errors.auto_send_sms" />
              </div>
            </div>
            <div class="space-y-4 pt-4">
              <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                  <h4 class="text-sm font-medium text-gray-900">Auto-send SMS after Voicemail</h4>
                  <p class="text-sm text-gray-500">Automatically send AI responses via SMS when customers leave a voicemail</p>
                </div>
                <ToggleSwitch id="auto_send_sms_after_voicemail" v-model="form.auto_send_sms_after_voicemail" :error="form.errors.auto_send_sms_after_voicemail" />
              </div>
            </div>
            <div class="flex justify-end">
              <Button 
                type="submit" 
                size="small"
                :loading="form.processing"
                label="Update"
                :disabled="form.processing"
                :icon="['fas', 'fa-save']"
              />
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

