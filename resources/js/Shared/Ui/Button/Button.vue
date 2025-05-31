<script setup>
import Button from 'primevue/button';

defineOptions({
  name: 'Button',
});

defineProps({
  icon: Array,
});
</script>

<template>
  <Button>
    <template #icon="item" v-if="icon">
      <font-awesome-icon :icon="icon" :class="[item.class, $attrs.iconClass]" />
    </template>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </Button>
</template>
