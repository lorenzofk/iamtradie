<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  label: String,
  href: String,
  icon: Array,
});

const isActive = computed(() => route().current(props.href));
</script>

<template>
  <Link
    :href="props.href"
    class="group flex items-center px-3 py-2.5 text-sm rounded-lg transition-colors font-medium"
    :class="[
      isActive
        ? 'bg-blue-300 border-r-4 border-blue-300 text-blue-300 font-semibold'
        : 'text-gray-500 hover:bg-blue-50 hover:text-blue-900'
    ]"
  >
    <font-awesome-icon
      :icon="props.icon"
      class="mr-3 h-5 w-5"
      :class="[
        isActive ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500'
      ]"
    />
    <span>{{ props.label }}</span>
  </Link>
</template> 