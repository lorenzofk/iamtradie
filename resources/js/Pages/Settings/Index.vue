
<script setup>
import { usePage } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import App from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import FormElement from '@/Shared/Ui/Form/FormElement.vue'
import FormLabel from '@/Shared/Ui/Form/FormLabel.vue';
import Input from '@/Shared/Ui/Form/Input.vue';
import InputNumber from '@/Shared/Ui/Form/InputNumber.vue';
import Select from '@/Shared/Ui/Form/Select.vue'
import TextArea from '@/Shared/Ui/Form/TextArea.vue'
import ToggleSwitch from '@/Shared/Ui/Form/ToggleSwitch.vue'
import { useToast } from '@Shared/Ui/Hooks/useToast';

const { showToast } = useToast();

defineOptions({
  layout: App
});

const props = defineProps({
  settings: Object,
  industry_types: Array,
  response_tones: Array
});

const user = usePage().props.auth?.user;

const form = useForm('post', route('settings.update'), {
  first_name: user?.first_name || '',
  last_name: user?.last_name || '',
  email: user?.email || '',
  phone_number: props.settings?.phone_number || '',
  business_name: props.settings?.business_name || '',
  location: props.settings?.location || '',
  industry_type: props.settings?.industry_type || 'plumbing',
  callout_fee: props.settings?.callout_fee || 0,
  hourly_rate: props.settings?.hourly_rate || 0,
  response_tone: props.settings?.response_tone || 'casual',
  preferred_cta: props.settings?.preferred_cta || '',
  auto_send_sms: props.settings?.auto_send_sms || false,
  auto_send_email: props.settings?.auto_send_email || false,
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

const copyToClipboard = (text) => {
  showToast('success', 'Copied to clipboard.');
};
</script>


<template>
  <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6 bg-white rounded-xl shadow-sm border-0 p-6">
      <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
    </div>

    <form @submit.prevent="onFormSubmit" class="space-y-6">
      <!-- Profile Information Card -->
      <div class="bg-white shadow-sm rounded-xl border-0 p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-user']" class="text-blue-600" />
            Profile Information
          </h2>
          <p class="text-sm text-gray-600 mt-1">Update your personal information and contact details.</p>
        </div>
        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <FormElement>
            <FormLabel for="first_name">First Name</FormLabel>
            <Input
              id="first_name"
              v-model="form.first_name"
              :error="form.errors.first_name"
              required
            />
          </FormElement>
          
          <FormElement>
            <FormLabel for="last_name">Last Name</FormLabel>
            <Input
              id="last_name"
              v-model="form.last_name"
              :error="form.errors.last_name"
              required
            />
          </FormElement>
          
          <FormElement class="sm:col-span-2">
            <FormLabel for="email">Email</FormLabel>
            <Input
              id="email"
              type="email"
              v-model="form.email"
              :error="form.errors.email"
              required
            />
          </FormElement>

          <FormElement>
            <FormLabel for="business_name">Business Name</FormLabel>
            <Input
              id="business_name"
              v-model="form.business_name"
              :error="form.errors.business_name"
              required
            />
          </FormElement>
          
          <FormElement>
            <FormLabel for="location">Location</FormLabel>
            <Input
              id="location"
              v-model="form.location"
              :error="form.errors.location"
              placeholder="Suburb, State"
              required
            />
          </FormElement>
          
          <FormElement>
            <FormLabel for="phone">Phone Number</FormLabel>
            <Input
              id="phone"
              v-model="form.phone_number"
              :error="form.errors.phone_number"
            />
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
      <div class="bg-white shadow-sm rounded-xl border-0 p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
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
      <!-- Response Preferences Card -->
      <div class="bg-white shadow-sm rounded-xl border-0 p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-purple-600" />
            Response Preferences
          </h2>
          <p class="text-sm text-gray-600 mt-1">Customize how AI generates your quote responses.</p>
        </div>
        
        <div class="space-y-4">
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
          
          <FormElement>
            <FormLabel for="preferred_cta">Preferred Call-to-Action</FormLabel>
            <TextArea
              id="preferred_cta"
              v-model="form.preferred_cta"
              :error="form.errors.preferred_cta"
              rows="3"
              placeholder="Give me a call if you need a quote!"
            />
          </FormElement>
          <!-- Auto-send Options -->
          <div class="space-y-4 pt-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
              <div>
                <h4 class="text-sm font-medium text-gray-900">Auto-send SMS Quotes</h4>
                <p class="text-sm text-gray-500">Automatically send AI responses via SMS when customers submit quotes</p>
              </div>
              <ToggleSwitch id="auto_send_sms" v-model="form.auto_send_sms" :error="form.errors.auto_send_sms" />
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
              <div>
                <h4 class="text-sm font-medium text-gray-900">Auto-send Email Quotes</h4>
                <p class="text-sm text-gray-500">Automatically send AI responses via email when customers submit quotes</p>
              </div>
              <ToggleSwitch id="auto_send_email" v-model="form.auto_send_email" :error="form.errors.auto_send_email" />
            </div>
          </div>
        </div>
      </div>
      <!-- SMS Integration Card -->
      <div class="bg-white shadow-sm rounded-xl border-0 p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-mobile-alt']" class="text-green-600" />
            SMS Integration
          </h2>
          <p class="text-sm text-gray-600 mt-1">Manage your SMS number for receiving quote requests.</p>
        </div>
        <!-- SMS Number Display -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="text-green-600" />
              </div>
              <div>
                <h4 class="text-sm font-semibold text-gray-900">SMS Number Assigned</h4>
                <p class="text-sm text-green-700 font-medium">{{ props.settings.agent_sms_number }}</p>
              </div>
            </div>
            <Button 
              size="small" 
              outlined 
              :icon="['fas', 'fa-copy']"
              label="Copy"
              @click="copyToClipboard(props.settings.agent_sms_number)"
            />
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
      <!-- Submit Button -->
      <div class="flex justify-end">
        <Button 
          type="submit" 
          size="small"
          :loading="form.processing"
          label="Save Settings"
          :disabled="form.processing"
          :icon="['fas', 'fa-save']"
        />
      </div>
    </form>
  </div>
</template>