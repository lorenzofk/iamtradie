<script setup>
import { router, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Public from '@/Layouts/Public.vue';
import FormElement from '@Shared/Ui/Form/FormElement.vue';
import Input from '@Shared/Ui/Form/Input.vue';
import Checkbox from '@Shared/Ui/Form/Checkbox.vue';
import Button from '@Shared/Ui/Button/Button.vue';
import { ref, onMounted } from 'vue';

defineOptions({
  layout: Public,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const showPassword = ref(false);
const isLoaded = ref(false);

const onFormSubmit = () => {
  form.post(route('login'), {
    preserveScroll: true,
    onSuccess: () => router.visit(route('dashboard')),
  });
};

onMounted(() => {
  isLoaded.value = true;
});
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 flex">
    <!-- Left Column - Branding & Value Proposition -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
      <!-- Animated Background -->
      <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-green-600/20"></div>
        <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-r from-blue-500/30 to-purple-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-120 h-120 bg-gradient-to-r from-green-500/30 to-blue-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1000ms"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-gradient-to-r from-purple-500/20 to-pink-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 500ms"></div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-20 w-2 h-2 bg-white/30 rounded-full animate-ping" style="animation-delay: 0s"></div>
        <div class="absolute top-40 right-32 w-1 h-1 bg-blue-300/40 rounded-full animate-ping" style="animation-delay: 1s"></div>
        <div class="absolute bottom-32 left-40 w-1.5 h-1.5 bg-green-300/40 rounded-full animate-ping" style="animation-delay: 2s"></div>
      </div>

      <!-- Content -->
      <div class="relative z-10 flex flex-col items-start p-12 text-white">
        <div>
          <!-- Logo -->
          <div class="flex items-center mb-8">
            <img src="/images/logo.png" alt="I am Tradie Logo" class="h-24 w-24 transform scale-200 mr-2" />
            <span class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">I am Tradie</span>
          </div>

          <!-- Headline -->
          <h1 class="text-4xl font-black mb-6 leading-tight">
            Never Miss Another
            <span class="bg-gradient-to-r from-sky-400 to-blue-400 bg-clip-text text-transparent">
              SMS Lead
            </span>
          </h1>

          <!-- Value Props -->
          <div class="space-y-4 mb-8">
            <div class="flex items-center">
              <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-white text-sm" />
              </div>
              <p class="text-blue-100 text-lg">AI responds to SMS in 3 seconds</p>
            </div>
            <div class="flex items-center">
              <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-white text-sm" />
              </div>
              <p class="text-blue-100 text-lg">Your own Australian phone number</p>
            </div>
            <div class="flex items-center">
              <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-white text-sm" />
              </div>
              <p class="text-blue-100 text-lg">Professional quotes using your pricing</p>
            </div>
          </div>

          <!-- Improved Testimonial -->
          <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mr-4">
                <span class="text-white font-bold text-lg">DM</span>
              </div>
              <div>
                <h4 class="font-semibold text-white">Dave Miller</h4>
                <p class="text-blue-200 text-sm">Electrician, Sydney</p>
              </div>
              <div class="ml-auto">
                <div class="flex text-yellow-400 text-sm">
                  <font-awesome-icon :icon="['fas', 'fa-star']" />
                  <font-awesome-icon :icon="['fas', 'fa-star']" />
                  <font-awesome-icon :icon="['fas', 'fa-star']" />
                  <font-awesome-icon :icon="['fas', 'fa-star']" />
                  <font-awesome-icon :icon="['fas', 'fa-star']" />
                </div>
              </div>
            </div>
            <p class="text-blue-100 italic leading-relaxed">
              "I'm booking 40% more jobs since using I am Tradie. The AI never sleeps, so I don't miss weekend emergencies anymore."
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
      <div class="w-full max-w-md">
        <!-- Mobile Logo (visible only on small screens) -->
        <div class="lg:hidden flex justify-center mb-6">
          <div class="flex items-center">
            <img src="/images/logo.png" alt="I am Tradie Logo" class="h-24 w-24 transform scale-200 mr-2" />
            <span class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">I am Tradie</span>
          </div>
        </div>

        <!-- Login Card -->
        <div class="bg-white/95 backdrop-blur-lg p-8 shadow-2xl rounded-3xl border border-white/20 transform transition-all duration-500" 
             :class="{ 'translate-y-0 opacity-100': isLoaded, 'translate-y-10 opacity-0': !isLoaded }">
          
          <!-- Header -->
          <div class="text-center mb-6">
            <h2 class="text-3xl font-black text-gray-900 mb-2">Welcome Back</h2>
            <p class="text-gray-600 text-lg">Sign in to your tradie dashboard</p>
          </div>

          <!-- Form -->
          <form @submit.prevent="onFormSubmit" class="space-y-5">
            <!-- Email Field -->
            <div class="space-y-2">
              <FormElement required label="Email Address" :error="form.errors.email">
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <font-awesome-icon :icon="['fas', 'fa-envelope']" class="text-gray-400" />
                  </div>
                  <Input
                    type="email"
                    class="w-full !pl-12 !pr-4 !py-3 !border-gray-300 focus:!border-blue-500 !shadow-sm !rounded-xl transition-all duration-300 hover:!border-gray-400"
                    v-model="form.email"
                    required
                    placeholder="dave@millerelectrical.com.au"
                  />
                </div>
              </FormElement>
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
              <FormElement required label="Password" :error="form.errors.password">
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <font-awesome-icon :icon="['fas', 'fa-lock']" class="text-gray-400" />
                  </div>
                  <Input
                    :type="showPassword ? 'text' : 'password'"
                    class="w-full !pl-12 !pr-12 !py-3 !border-gray-300 focus:!border-blue-500 !shadow-sm !rounded-xl transition-all duration-300 hover:!border-gray-400"
                    v-model="form.password"
                    required
                    placeholder="Enter your password"
                  />
                  <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                  >
                    <font-awesome-icon :icon="['fas', showPassword ? 'fa-eye-slash' : 'fa-eye']" />
                  </button>
                </div>
              </FormElement>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between pt-2">
              <div class="flex items-center gap-3">
                <Checkbox :binary="true" v-model="form.remember" :inputId="'remember_me'" class="!rounded-md" />
                <label :for="'remember_me'" class="text-gray-700 font-medium">Remember me</label>
              </div>
              <Link :href="route('password.request')" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                Forgot password?
              </Link>
            </div>

            <!-- Submit Button -->
            <Button
              type="submit"
              :disabled="form.processing"
              class="w-full !py-3 !text-lg !font-bold !rounded-xl !bg-gradient-to-r !from-blue-600 !to-green-600 hover:!from-blue-700 hover:!to-green-700 !shadow-xl hover:!shadow-2xl !transform hover:!scale-105 !transition-all !duration-300"
            >
              <div class="flex items-center justify-center">
                <font-awesome-icon :icon="['fas', 'fa-spinner']" class="fa-spin mr-3" v-if="form.processing" />
                <font-awesome-icon :icon="['fas', 'fa-sign-in-alt']" class="mr-3" v-else />
                Sign In
              </div>
            </Button>

            <!-- Divider -->
            <hr class="border-gray-300">

            <!-- Contact for Access -->
            <div class="text-center">
              <p class="text-gray-600 mb-4">Need help?</p>
              <a href="mailto:hello@iamtradie.com.au" 
                 class="inline-flex items-center px-6 py-3 border-2 border-blue-600 text-blue-600 font-bold rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300 hover:scale-105">
                <font-awesome-icon :icon="['fas', 'fa-envelope']" class="mr-2" />
                Contact Us
              </a>
            </div>
          </form>

          <!-- Security Badge -->
          <div class="mt-6 text-center">
            <div class="inline-flex items-center text-sm text-gray-500">
              <font-awesome-icon :icon="['fas', 'fa-shield-alt']" class="text-green-500 mr-2" />
              Your data is protected with enterprise-grade security.
            </div>
          </div>
        </div>
        <!-- Footer -->
        <div class="mt-4 text-center text-white">
          <p class="text-sm">
            <span class="font-semibold">🇦🇺 Australian owned & operated</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .w-120 {
    width: 30rem;
  }
  
  .h-120 {
    height: 30rem;
  }

  /* Custom animation for form appearance */
  @keyframes slideInUp {
    from {
      opacity: 0;
      transform: translateY(40px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Enhanced focus states */
  .group:focus-within .group-focus\:scale-105 {
    transform: scale(1.05);
  }

  /* Smooth transitions for all interactive elements */
  * {
    transition: all 0.3s ease;
  }

  /* Custom scrollbar for webkit browsers */
  ::-webkit-scrollbar {
    width: 8px;
  }

  ::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  ::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #3b82f6, #10b981);
    border-radius: 10px;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #2563eb, #059669);
  }
</style>