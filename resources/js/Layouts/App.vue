<script setup>
import { computed } from 'vue';
import SidebarItem from './SidebarItem.vue';
import { usePage, router } from '@inertiajs/vue3';
import { useToast as PrimeVueUseToast } from 'primevue/usetoast';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import Toast from '@Shared/Ui/Messages/Toast.vue';

const { setToast } = useToast();

const navLinks = [
  { label: 'Dashboard', href: route('dashboard'), icon: ['fas', 'fa-chart-bar'] },
  { label: 'Quote History', href: route('quotes.index'), icon: ['fas', 'fa-history'] },
  { label: 'SMS Integration', href: route('integrations.sms.index'), icon: ['fas', 'fa-mobile-alt'] },
  { label: 'Billing', href: route('billing.index'), icon: ['fas', 'fa-credit-card'] },
  { label: 'Settings', href: route('settings'), icon: ['fas', 'fa-cog'] },
];

const onLogout = (e) => {
  e.preventDefault();
  router.post(route('logout'));
};

const user = computed(() => {
  return usePage().props.auth?.user || { name: 'User', role: 'Tradie' };
});


function userInitials(user) {
  if (!user) return 'U';

  if (user.first_name || user.last_name) {
    const names = `${user.first_name} ${user.last_name}`.split(' ');
    return names.map(n => n[0]).join('').toUpperCase();
  }

  return 'U';
}


setToast(PrimeVueUseToast());
</script>

<template>
  <div class="flex min-h-screen">
    <Toast />
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between min-h-screen">
      <div class="flex flex-col flex-grow pt-6 pb-4 overflow-y-auto">
        <!-- Logo -->
        <div class="flex items-center flex-shrink-0 px-6 mb-2">
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center">
              <img src="/images/logo.png" alt="I am Tradie Logo" class="h-10 w-10 transform scale-200 mr-2" />
            </div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">I am Tradie</h1>
          </div>
        </div>
        <hr class="my-4 border-gray-200">
        <!-- Navigation -->
        <nav class="flex-1 px-2 space-y-1">
          <SidebarItem v-for="link in navLinks" :key="link.label" :label="link.label" :href="link.href" :icon="link.icon" />
        </nav>
      </div>
      <!-- User Profile -->
      <div class="flex-shrink-0 flex border-t border-gray-200 p-4 items-center w-full">
        <div class="w-10 h-10 bg-blue-300 rounded-full flex items-center justify-center">
          <span class="text-white text-base font-medium">{{ userInitials(user) }}</span>
        </div>
        <div class="ml-3 flex-1">
          <p class="text-sm font-medium text-gray-700">{{ user.name }}</p>
          <p class="text-xs text-gray-400 capitalize">{{ user.role || 'Tradie' }}</p>
        </div>
        <button @click="onLogout" class="cursor-pointer ml-2 text-gray-400 hover:text-gray-600 transition-colors">
          <font-awesome-icon :icon="['fas', 'fa-sign-out-alt']" class="h-4 w-4" />
        </button>
      </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 bg-gray-50 p-8">
      <slot />
    </main>
  </div>
</template>