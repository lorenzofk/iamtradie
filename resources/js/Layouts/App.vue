<script setup>
import SidebarItem from './SidebarItem.vue';
import { usePage, router } from '@inertiajs/vue3';

const user = usePage().props.auth?.user || { name: 'User', role: 'User' };
console.log('Sidebar user:', user);

const navLinks = [
  { label: 'Dashboard', href: route('home'), icon: ['fas', 'fa-chart-bar'] },
  { label: 'New Quote', href: route('home'), icon: ['fas', 'fa-plus'] },
  { label: 'Quote History', href: route('home'), icon: ['fas', 'fa-history'] },
  { label: 'SMS Integration', href: route('home'), icon: ['fas', 'fa-mobile-alt'] },
  { label: 'Embed Form', href: route('home'), icon: ['fas', 'fa-code'] },
  { label: 'Settings', href: route('settings'), icon: ['fas', 'fa-cog'] },
];

const onLogout = (e) => {
  e.preventDefault();
  router.post(route('logout'));
};

function userInitials(user) {
  if (!user) return 'U';

  if (user.first_name || user.last_name) {
    const names = `${user.first_name} ${user.last_name}`.split(' ');
    return names.map(n => n[0]).join('').toUpperCase();
  }

  return 'U';
}
</script>

<template>
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between min-h-screen">
      <div class="flex flex-col flex-grow pt-6 pb-4 overflow-y-auto">
        <!-- Logo -->
        <div class="flex items-center flex-shrink-0 px-6 mb-8">
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-300 rounded-lg flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-quote-right']" class="text-white text-xl" />
            </div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">QuoteAI</h1>
          </div>
        </div>
        <!-- Navigation -->
        <nav class="flex-1 px-2 space-y-1">
          <SidebarItem v-for="item in navLinks" :key="item.label" :label="item.label" :href="item.href" :icon="item.icon" />
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
```