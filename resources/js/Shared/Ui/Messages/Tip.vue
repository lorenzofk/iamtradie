<script setup>
import { ref } from 'vue';

const isSideBarVisible = ref(false);

const props = defineProps({
  title: {
    type: String,
    default: 'Tip',
  },
});
</script>

<template>
  <font-awesome-icon
    :icon="['fas', 'info-circle']"
    class="mx-2 text-primary cursor-pointer"
    @click.stop.prevent="isSideBarVisible = !isSideBarVisible"
  />
  <Drawer position="right" v-model:visible="isSideBarVisible" pt:header:class="border-b mb-3">
    <template #header>
      <div class="text-xl">
        <font-awesome-icon :icon="['fas', 'info-circle']" class="mr-3 text-primary cursor-pointer" />
        <span class="font-bold">{{ title }}</span>
      </div>
    </template>
    <slot />
  </Drawer>
</template>
