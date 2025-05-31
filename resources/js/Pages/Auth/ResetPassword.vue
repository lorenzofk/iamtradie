<script setup>
import { Link, useForm, router } from '@inertiajs/vue3';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import FormElement from '@Shared/Ui/Form/FormElement.vue';
import Input from '@Shared/Ui/Form/Input.vue';
import Button from '@Shared/Ui/Button/Button.vue';
import Public from '@/Layouts/Public.vue';

defineOptions({
  layout: Public,
});

const props = defineProps({
  token: String,
  email: String,
});

const { showToast } = useToast();

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const onFormSubmit = () => {
  form.post(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      showToast('success', 'Password reset successfully');
      router.visit(route('login'));
    },
    onError: () => {
      const errorMessage = form.errors.email || 'There was an error resetting your password.';
      showToast('error', errorMessage);
    },
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
          <h1 class="text-2xl font-bold text-neutralDark">Reset your password</h1>
          <p class="text-neutralDark text-sm opacity-70">Enter your new password below</p>
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

            <FormElement required label="Password" :error="form.errors.password">
              <Input
                type="password"
                class="w-full !px-4 !py-3 !border-gray-300 focus:!border-primary !shadow-sm"
                v-model="form.password"
                required
                placeholder="Enter your new password"
              />
            </FormElement>

            <FormElement required label="Confirm Password" :error="form.errors.password_confirmation">
              <Input
                type="password"
                class="w-full !px-4 !py-3 !border-gray-300 focus:!border-primary !shadow-sm"
                v-model="form.password_confirmation"
                required
                placeholder="Confirm your new password"
              />
            </FormElement>
          </div>

          <Button
            type="submit"
            label="Reset password"
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
