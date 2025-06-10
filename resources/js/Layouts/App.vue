<script setup>
import { computed, ref } from 'vue';
import SidebarItem from './SidebarItem.vue';
import { usePage, router } from '@inertiajs/vue3';
import { useToast as PrimeVueUseToast } from 'primevue/usetoast';
import { useToast } from '@Shared/Ui/Hooks/useToast';
import Toast from '@Shared/Ui/Messages/Toast.vue';

const { setToast } = useToast();

// Mobile menu state
const isMobileMenuOpen = ref(false);

const navLinks = [
  { label: 'Dashboard', href: route('dashboard'), icon: ['fas', 'fa-chart-bar'] },
  { label: 'Messages', href: route('quotes.index'), icon: ['fas', 'fa-envelope'] },
  { label: 'Billing', href: route('billing.index'), icon: ['fas', 'fa-credit-card'] },
  { label: 'Settings', href: route('settings.basic.index'), icon: ['fas', 'fa-cog'] },
  { label: 'Communication Hub', href: route('settings.communication.index'), icon: ['fas', 'fa-mobile-alt'] },
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

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
  // Prevent body scroll when menu is open
  document.body.style.overflow = isMobileMenuOpen.value ? 'hidden' : '';
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
  // Restore body scroll when menu is closed
  document.body.style.overflow = '';
};

setToast(PrimeVueUseToast());
</script>

<template>
  <div class="flex min-h-screen overflow-x-hidden">
    <Toast />
    
    <!-- Mobile menu button -->
    <div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 px-4 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 ml-2">
          <img src="/images/logo.png" alt="PingMate Logo" class="h-8 w-8 transform scale-220" />
        </div>
        <button
          @click="toggleMobileMenu"
          class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors"
        >
          <font-awesome-icon 
            :icon="['fas', isMobileMenuOpen ? 'fa-times' : 'fa-bars']" 
            class="h-5 w-5" 
          />
        </button>
      </div>
    </div>

    <!-- Mobile menu overlay -->
    <div 
      v-if="isMobileMenuOpen"
      class="lg:hidden fixed inset-0 z-40 flex"
      @click="closeMobileMenu"
    >
      <!-- Backdrop -->
      <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
      
      <!-- Mobile sidebar -->
      <div class="relative flex-1 flex flex-col max-w-64 w-full bg-white" @click.stop>
        <div class="flex flex-col h-full pt-20">
          <!-- Navigation -->
          <nav class="flex-1 px-2 space-y-1 overflow-y-auto pb-4">
            <div v-for="link in navLinks" :key="link.label" @click="closeMobileMenu">
              <SidebarItem :label="link.label" :href="link.href" :icon="link.icon" />
            </div>
          </nav>
          
          <!-- User Profile - Sticky at bottom -->
          <div class="flex-shrink-0 flex border-t border-gray-200 p-4 items-center w-full bg-white">
            <div class="w-10 h-10 bg-blue-300 rounded-full flex items-center justify-center">
              <span class="text-white text-base font-medium">{{ userInitials(user) }}</span>
            </div>
            <div class="ml-3 flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-700 truncate">{{ user.name }}</p>
              <p class="text-xs text-gray-400 capitalize">{{ user.role || 'Tradie' }}</p>
            </div>
            <button @click="onLogout" class="cursor-pointer ml-2 text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0 p-1">
              <font-awesome-icon :icon="['fas', 'fa-sign-out-alt']" class="h-4 w-4" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Desktop Sidebar -->
    <aside class="hidden lg:flex w-64 bg-white border-r border-gray-200 flex-col h-screen fixed">
      <div class="flex flex-col flex-grow">
        <!-- Logo -->
        <div class="flex items-center justify-center flex-shrink-0 px-6 pt-6 mb-2">
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center">
              <img src="/images/logo.png" alt="PingMate Logo" class="h-10 w-10 transform scale-220" />
            </div>
          </div>
        </div>
        <hr class="my-4 border-gray-200">
        
        <!-- Navigation -->
        <nav class="flex-1 px-2 space-y-1 overflow-y-auto pb-4">
          <SidebarItem v-for="link in navLinks" :key="link.label" :label="link.label" :href="link.href" :icon="link.icon" />
        </nav>
      </div>
      
      <!-- User Profile - Sticky at bottom -->
      <div class="flex-shrink-0 flex border-t border-gray-200 p-4 items-center w-full bg-white">
        <div class="w-10 h-10 bg-blue-300 rounded-full flex items-center justify-center">
          <span class="text-white text-base font-medium">{{ userInitials(user) }}</span>
        </div>
        <div class="ml-3 flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-700 truncate">{{ user.name }}</p>
          <p class="text-xs text-gray-400 capitalize">{{ user.role || 'Tradie' }}</p>
        </div>
        <button @click="onLogout" class="cursor-pointer ml-2 text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0 p-1">
          <font-awesome-icon :icon="['fas', 'fa-sign-out-alt']" class="h-4 w-4" />
        </button>
      </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 bg-gray-50 p-4 lg:p-8 pt-20 lg:pt-8 lg:ml-64 overflow-y-auto">
      <slot />
    </main>
  </div>
</template>