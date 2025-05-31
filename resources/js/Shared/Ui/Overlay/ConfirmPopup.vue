<script setup>
import ConfirmPopup from 'primevue/confirmpopup';
</script>

<template>
  <ConfirmPopup>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </ConfirmPopup>
</template>