<script setup>
import Drawer from 'primevue/drawer';
</script>

<template>
  <Drawer :blockScroll="true" pt:header:class="!px-4 !pt-2 !pb-1" pt:content:class="!px-4 !py-2">
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </Drawer>
</template>
