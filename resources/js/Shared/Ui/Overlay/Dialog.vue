<script setup>
import Dialog from 'primevue/dialog';
</script>

<template>
  <Dialog modal :draggable="false">
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </Dialog>
</template>
