<script setup>
import { usePage } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import App from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import FormElement from '@/Shared/Ui/Form/FormElement.vue';
import FormLabel from '@/Shared/Ui/Form/FormLabel.vue';
import Input from '@/Shared/Ui/Form/Input.vue';
import InputNumber from '@/Shared/Ui/Form/InputNumber.vue';
import Select from '@/Shared/Ui/Form/Select.vue';
import { useToast } from '@Shared/Ui/Hooks/useToast';

const { showToast } = useToast();

defineOptions({
  layout: App,
});

const props = defineProps({
  settings: Object,
  industry_types: Array,
  response_tones: Array,
});

const user = usePage().props.auth?.user;

const form = useForm('post', route('settings.basic.update'), {
  first_name: user?.first_name || '',
  last_name: user?.last_name || '',
  email: user?.email || '',
  phone_number: props.settings?.phone_number || '',
  business_name: props.settings?.business_name || '',
  business_location: props.settings?.business_location || '',
  industry_type: props.settings?.industry_type || 'plumbing',
  callout_fee: props.settings?.callout_fee || 0,
  hourly_rate: props.settings?.hourly_rate || 0,
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
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4 lg:mb-6 bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
      <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Settings</h1>
    </div>

    <form @submit.prevent="onFormSubmit" class="space-y-4 lg:space-y-6">
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
