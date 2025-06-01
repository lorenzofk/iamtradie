
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
  industryTypes: Array,
  responseTones: Array
});

const user = usePage().props.auth?.user;

const form = useForm('post', route('settings.update'), {
  first_name: user?.first_name || '',
  last_name: user?.last_name || '',
  email: user?.email || '',
  phone: props.settings?.phone || '',
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
</script>


<template>
  <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Account Settings</h1>
        
        <form @submit.prevent="onFormSubmit" class="space-y-6">
          <!-- Personal Information -->
          <div class="border-b border-gray-200 pb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h2>
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
                <FormLabel for="phone">Phone</FormLabel>
                <Input
                  id="phone"
                  v-model="form.phone"
                  :error="form.errors.phone"
                />
              </FormElement>
            </div>
          </div>

          <!-- Business Information -->
          <div class="border-b border-gray-200 pb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Business Information</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <FormElement>
                <FormLabel for="industry_type">Industry Type</FormLabel>
                <Select
                  placeholder="Select Industry Type"
                  class="w-full"
                  v-model="form.industry_type"
                  optionLabel="label"
                  optionValue="id"
                  :options="industryTypes"
                />
              </FormElement>
              
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

          <!-- AI Preferences -->
          <div class="border-b border-gray-200 pb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">AI Response Preferences</h2>
            <div class="grid grid-cols-1 gap-4">
              <FormElement>
                <FormLabel for="response_tone">Response Tone</FormLabel>
                <Select
                  id="response_tone"
                  v-model="form.response_tone"
                  optionLabel="label"
                  optionValue="id"
                  :options="responseTones"
                  :error="form.errors.response_tone"
                  required
                />
              </FormElement>
              
              <FormElement>
                <FormLabel for="preferred_cta">Preferred Call-to-Action Message</FormLabel>
                <TextArea
                  id="preferred_cta"
                  v-model="form.preferred_cta"
                  :error="form.errors.preferred_cta"
                  rows="3"
                  placeholder="Enter your custom call-to-action message..."
                />
              </FormElement>
            </div>
          </div>

          <!-- Automation Settings -->
          <div class="border-b border-gray-200 pb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Automation Settings</h2>
            <div class="space-y-4">
              <div class="flex items-center">
                <ToggleSwitch id="auto_send_sms" v-model="form.auto_send_sms" :error="form.errors.auto_send_sms" />
                <FormLabel for="auto_send_sms" class="ml-3">Auto Send SMS</FormLabel>
              </div>
              
              <div class="flex items-center">
                <ToggleSwitch id="auto_send_email" v-model="form.auto_send_email" :error="form.errors.auto_send_email" />
                <FormLabel for="auto_send_email" class="ml-3">Auto Send Email</FormLabel>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <Button type="submit" label="Save Settings" :disabled="form.processing" class="px-6 py-2" />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>