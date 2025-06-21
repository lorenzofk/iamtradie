<script setup>
import { usePage } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import Layout from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import FormElement from '@/Shared/Ui/Form/FormElement.vue';
import FormLabel from '@/Shared/Ui/Form/FormLabel.vue';
import Input from '@/Shared/Ui/Form/Input.vue';
import InputNumber from '@/Shared/Ui/Form/InputNumber.vue';
import Select from '@/Shared/Ui/Form/Select.vue';
import ToggleSwitch from '@/Shared/Ui/Form/ToggleSwitch.vue';
import TextArea from '@/Shared/Ui/Form/TextArea.vue';
import { useToast } from '@Shared/Ui/Hooks/useToast';

const { showToast } = useToast();

defineOptions({
  layout: Layout,
});

const props = defineProps({
  settings: Object,
  sms_data: Object,
  industry_types: Array,
  response_tones: Array,
});

const user = usePage().props.auth?.user;

const form = useForm('post', route('settings.update'), {
  // Basic settings from Basic.vue
  first_name: user?.first_name || '',
  last_name: user?.last_name || '',
  email: user?.email || '',
  phone_number: props.settings?.phone_number || '',
  business_name: props.settings?.business_name || '',
  business_location: props.settings?.business_location || '',
  industry_type: props.settings?.industry_type || 'plumbing',
  callout_fee: props.settings?.callout_fee || 0,
  hourly_rate: props.settings?.hourly_rate || 0,
  
  // Communication settings from Communication.vue
  response_tone: props.settings?.response_tone || 'casual',
  auto_send_sms: props.settings?.auto_send_sms || false,
  call_forward_enabled: props.settings?.call_forward_enabled || false,
  call_ring_duration: props.settings?.call_ring_duration || 20,
  auto_send_sms_after_voicemail: props.settings?.auto_send_sms_after_voicemail || false,
  voicemail_message:
    props.settings?.voicemail_message ||
    "Hi, I'm not available right now. Please leave a message and I'll get back to you with a quote.",
});

const onFormSubmit = () => {
  form.submit({
    preserveScroll: true,
    onSuccess: () => {
      showToast('success', 'Settings updated successfully.');
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
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div
      class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4 lg:mb-6 bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6 gap-4"
    >
      <div>
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Settings</h1>
        <p class="text-sm text-gray-600 mt-1">Manage your profile, business information, and communication preferences</p>
      </div>
      <div class="min-w-0 lg:max-w-xs">
        <div class="flex items-center gap-2 mb-2">
          <div class="w-4 h-4 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
            <font-awesome-icon :icon="['fas', 'fa-chart-line']" class="text-gray-600 text-sm" />
          </div>
          <div class="text-sm min-w-0">
            <span class="font-medium text-gray-900">{{ props.sms_data?.quotes_used || 0 }}</span>
            <span class="text-gray-500">/ {{ props.sms_data?.quotes_limit }} quotes used</span>
          </div>
        </div>
        <!-- Progress Bar -->
        <div class="w-full h-1 bg-gray-200 rounded-full overflow-hidden">
          <div
            class="h-full bg-blue-500 rounded-full transition-all duration-300"
            :style="{ width: `${((props.sms_data?.quotes_used || 0) / props.sms_data?.quotes_limit) * 100}%` }"
          ></div>
        </div>
      </div>
    </div>

    <form @submit.prevent="onFormSubmit" class="space-y-4 lg:space-y-6">
      <!-- Business Phone Number Section -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="mb-4 lg:mb-6">
          <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-blue-600" />
            Your Business Number
          </h2>
          <p class="text-sm text-gray-600 mt-1">Unified phone number for SMS and voice communications</p>
        </div>

        <!-- Active Number Display -->
        <div
          class="bg-green-50 border border-green-200 rounded-lg p-4 flex flex-col sm:flex-row sm:items-center justify-between mb-4 lg:mb-6 gap-4"
        >
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
              <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="text-green-600" />
            </div>
            <div class="min-w-0">
              <p class="text-sm font-medium text-gray-900">Active Business Number</p>
              <p class="text-lg font-semibold text-green-800 break-all">{{ props.settings.agent_sms_number }}</p>
              <p class="text-xs text-green-700 mt-1">Handles both SMS and voice calls</p>
            </div>
          </div>
          <Button
            @click="copyPhoneNumber"
            size="small"
            label="Copy"
            outlined
            :icon="['fas', 'fa-copy']"
            class="w-full sm:w-auto flex-shrink-0"
          />
        </div>

        <!-- Current Configuration Status -->
        <div class="pt-4 border-t border-gray-100">
          <h3 class="text-sm font-medium text-gray-900 mb-3">Current Configuration</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-gray-600 text-sm flex-shrink-0" />
                <span class="text-sm text-gray-700">SMS Active</span>
              </div>
              <span class="text-xs font-medium text-green-700">On</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-phone-volume']" class="text-gray-600 text-sm flex-shrink-0" />
                <span class="text-sm text-gray-700">Call Handling</span>
              </div>
              <span class="text-xs font-medium text-gray-900">
                {{ form.call_forward_enabled ? 'Forward' : 'Voicemail' }}
              </span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-dollar-sign']" class="text-gray-600 text-sm flex-shrink-0" />
                <span class="text-sm text-gray-700">Rates</span>
              </div>
              <span class="text-xs font-medium text-gray-900">
                ${{ props.settings.callout_fee }} + ${{ props.settings.hourly_rate }}/hr
              </span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-comment-dots']" class="text-gray-600 text-sm flex-shrink-0" />
                <span class="text-sm text-gray-700">AI Tone</span>
              </div>
              <span class="text-xs font-medium text-gray-900 capitalize">{{ props.settings.response_tone }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Profile Information Card -->
      <div class="bg-white shadow-sm rounded-xl border-0 p-4 lg:p-6">
        <div class="mb-4 lg:mb-6">
          <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-user']" class="text-blue-600" />
            Profile Information
          </h2>
          <p class="text-sm text-gray-600 mt-1">Update your personal information and contact details.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
          <FormElement>
            <FormLabel for="first_name">First Name</FormLabel>
            <Input id="first_name" v-model="form.first_name" :error="form.errors.first_name" required />
          </FormElement>

          <FormElement>
            <FormLabel for="last_name">Last Name</FormLabel>
            <Input id="last_name" v-model="form.last_name" :error="form.errors.last_name" required />
          </FormElement>

          <FormElement class="lg:col-span-2">
            <FormLabel for="email">Email</FormLabel>
            <Input id="email" type="email" v-model="form.email" :error="form.errors.email" required />
          </FormElement>

          <FormElement>
            <FormLabel for="business_name">Business Name</FormLabel>
            <Input id="business_name" v-model="form.business_name" :error="form.errors.business_name" required />
          </FormElement>

          <FormElement>
            <FormLabel for="business_location">Location</FormLabel>
            <Input
              id="business_location"
              v-model="form.business_location"
              :error="form.errors.business_location"
              placeholder="Suburb, State"
              required
            />
          </FormElement>

          <FormElement>
            <FormLabel for="phone">Phone Number</FormLabel>
            <Input id="phone" v-model="form.phone_number" :error="form.errors.phone_number" />
          </FormElement>

          <FormElement>
            <FormLabel for="industry_type">Industry Type</FormLabel>
            <Select
              placeholder="Select your trade"
              class="w-full"
              v-model="form.industry_type"
              optionLabel="label"
              optionValue="id"
              :options="industry_types"
            />
          </FormElement>
        </div>
      </div>

      <!-- Base Pricing Card -->
      <div class="bg-white shadow-sm rounded-xl border-0 p-4 lg:p-6">
        <div class="mb-4 lg:mb-6">
          <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-dollar-sign']" class="text-green-600" />
            Base Pricing
          </h2>
          <p class="text-sm text-gray-600 mt-1">Set your standard rates for AI to include in quote responses.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <FormElement>
            <FormLabel for="callout_fee">Callout Fee ($)</FormLabel>
            <InputNumber
              id="callout_fee"
              v-model="form.callout_fee"
              :error="form.errors.callout_fee"
              :min="0"
              :step="0.01"
              required
            />
          </FormElement>

          <FormElement>
            <FormLabel for="hourly_rate">Hourly Rate ($)</FormLabel>
            <InputNumber
              id="hourly_rate"
              v-model="form.hourly_rate"
              :error="form.errors.hourly_rate"
              :min="1"
              :step="0.01"
              required
            />
          </FormElement>
        </div>
      </div>

      <!-- Voice Call Settings Section -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="mb-4 lg:mb-6">
          <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-phone-volume']" class="text-orange-600" />
            Voice Call Settings
          </h2>
          <p class="text-sm text-gray-600 mt-1">Configure how incoming calls are handled and processed.</p>
        </div>

        <div class="space-y-4 lg:space-y-6">
          <!-- Call Forwarding Section -->
          <div class="space-y-4 pt-4">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Call Handling</h3>
            <div class="bg-white border border-gray-200 rounded-lg divide-y divide-gray-100">
              <div class="flex items-center justify-between p-4">
                <div class="flex-1 min-w-0 pr-4">
                  <div class="flex items-center gap-2 mb-1">
                    <font-awesome-icon :icon="['fas', 'fa-phone-alt']" class="text-orange-500 text-sm" />
                    <h4 class="text-sm font-medium text-gray-900">Call Forwarding</h4>
                  </div>
                  <p class="text-sm text-gray-500">Forward calls to your business phone number before voicemail</p>
                </div>
                <ToggleSwitch
                  id="call_forward_enabled"
                  v-model="form.call_forward_enabled"
                  :error="form.errors.call_forward_enabled"
                  class="flex-shrink-0"
                />
              </div>
            </div>
          </div>

          <div v-if="form.call_forward_enabled" class="space-y-4 pt-4">
            <FormElement>
              <FormLabel for="call_ring_duration">Ring duration before voicemail</FormLabel>
              <InputNumber
                id="call_ring_duration"
                v-model="form.call_ring_duration"
                :error="form.errors.call_ring_duration"
              />
            </FormElement>
          </div>

          <div class="space-y-4 pt-4">
            <FormElement>
              <FormLabel for="voicemail_message">Voicemail message</FormLabel>
              <TextArea
                id="voicemail_message"
                :rows="2"
                v-model="form.voicemail_message"
                :error="form.errors.voicemail_message"
              />
            </FormElement>
          </div>
        </div>
      </div>

      <!-- AI Response Settings Section -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="mb-4 lg:mb-6">
          <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-purple-600" />
            AI Response Settings
          </h2>
          <p class="text-sm text-gray-600 mt-1">Configure how AI generates and sends quotes for both SMS and voice</p>
        </div>

        <div class="space-y-4 lg:space-y-6">
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

          <!-- Auto SMS Settings Section -->
          <div class="space-y-4 pt-4">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Automatic Responses</h3>
            <div class="bg-white border border-gray-200 rounded-lg divide-y divide-gray-100">
              <div class="flex items-center justify-between p-4">
                <div class="flex-1 min-w-0 pr-4">
                  <div class="flex items-center gap-2 mb-1">
                    <font-awesome-icon :icon="['fas', 'fa-comment-dots']" class="text-blue-500 text-sm" />
                    <h4 class="text-sm font-medium text-gray-900">Auto-send SMS Quotes</h4>
                  </div>
                  <p class="text-sm text-gray-500">
                    Automatically send AI responses via SMS when customers submit quotes
                  </p>
                </div>
                <ToggleSwitch
                  id="auto_send_sms"
                  v-model="form.auto_send_sms"
                  :error="form.errors.auto_send_sms"
                  class="flex-shrink-0"
                />
              </div>

              <div class="flex items-center justify-between p-4">
                <div class="flex-1 min-w-0 pr-4">
                  <div class="flex items-center gap-2 mb-1">
                    <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-purple-500 text-sm" />
                    <h4 class="text-sm font-medium text-gray-900">Auto-send SMS after Voicemail</h4>
                  </div>
                  <p class="text-sm text-gray-500">
                    Automatically send AI responses via SMS when customers leave a voicemail
                  </p>
                </div>
                <ToggleSwitch
                  id="auto_send_sms_after_voicemail"
                  v-model="form.auto_send_sms_after_voicemail"
                  :error="form.errors.auto_send_sms_after_voicemail"
                  class="flex-shrink-0"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end">
        <Button
          type="submit"
          size="small"
          :loading="form.processing"
          label="Update Settings"
          :disabled="form.processing"
          :icon="['fas', 'fa-save']"
          class="w-full sm:w-auto"
        />
      </div>
    </form>
  </div>
</template> 