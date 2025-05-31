<script setup>
import { router, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Public from '@/Layouts/Public.vue';
import FormElement from '@Shared/Ui/Form/FormElement.vue';
import Input from '@Shared/Ui/Form/Input.vue';
import Checkbox from '@Shared/Ui/Form/Checkbox.vue';
import Button from '@Shared/Ui/Button/Button.vue';

defineOptions({
  layout: Public,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const onFormSubmit = () => {
  form.post(route('login'), {
    preserveScroll: true,
    onSuccess: () => router.visit(route('home')),
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
          <h1 class="text-2xl font-bold text-neutralDark">Welcome back</h1>
          <p class="text-neutralDark text-sm opacity-70">Sign in to your account</p>
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
                placeholder="••••••••"
              />
            </FormElement>

            <div class="flex items-center justify-between pt-2">
              <div class="flex items-center gap-2">
                <Checkbox :binary="true" v-model="form.remember" :inputId="'remember_me'" />
                <label :for="'remember_me'" class="text-sm text-gray-600">Remember me</label>
              </div>
              <Link :href="route('password.request')" class="text-sm text-primary hover:text-secondary">
                Forgot password?
              </Link>
            </div>
          </div>

          <Button
            type="submit"
            label="Sign in"
            :disabled="form.processing"
            class="w-full"
          />

          <div class="text-center text-sm text-gray-600">
            Don't have an account?
            <Link :href="route('home')" class="font-medium text-primary hover:text-secondary">Contact us</Link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template> 