<script setup>
import Message from 'primevue/message';
</script>

<template>
  <Message>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </Message>
</template>
