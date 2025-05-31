<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import FormElement from '@Shared/Ui/Form/FormElement.vue';
import Input from '@Shared/Ui/Form/Input.vue';
import Button from '@Shared/Ui/Button/Button.vue';
import Public from '@/Layouts/Public.vue';

defineOptions({
  layout: Public,
});

const { showToast } = useToast();

const form = useForm({
  email: '',
});

const onFormSubmit = () => {
  form.post(route('password.email'), {
    preserveScroll: true,
    onSuccess: () =>
      showToast(
        'success',
        'If an account exists for this email address, you will receive a password reset link shortly.'
      ),
    onError: () => showToast('error', 'There was an error sending the reset link.'),
  });
};
</script>

<template>
  <div class="flex items-center justify-center min-h-screen bg-neutralLight">
    <div class="w-full max-w-md mx-auto">
      <div class="bg-white p-8 shadow-xl rounded-lg space-y-6 border border-gray-100">
        <div class="text-center space-y-2">
          <div class="flex justify-center mb-2">
            <div class="w-12 h-12 rounded-md bg-primary flex items-center justify-center border-2 border-white">
              <span class="text-white text-xl font-bold">LK</span>
            </div>
          </div>
          <h1 class="text-2xl font-bold text-neutralDark">Forgot your password?</h1>
          <p class="text-neutralDark text-sm opacity-70">Enter your email to receive a reset link</p>
        </div>

        <form @submit.prevent="onFormSubmit" class="space-y-4">
          <div class="space-y-4">
            <FormElement required label="Email" :error="form.errors.email">
              <Input
                type="email"
                class="w-full !px-4 !py-3 !border-gray-300 focus:!border-primary !shadow-sm"
                v-model="form.email"
                required
                placeholder="name@example.com"
              />
            </FormElement>
          </div>

          <Button
            type="submit"
            label="Send reset link"
            :disabled="form.processing"
            class="w-full !bg-primary hover:!bg-secondary !border-transparent !text-white !px-4 !py-3 !rounded-lg !shadow-sm"
          />

          <div class="text-center text-sm text-gray-600">
            Remember your password?
            <Link :href="route('login')" class="font-medium text-primary hover:text-secondary">Sign in</Link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
