<script setup>
import ConfirmDialog from 'primevue/confirmdialog';
</script>

<template>
  <ConfirmDialog>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </ConfirmDialog>
</template>
