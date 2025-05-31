<script setup>
import Select from 'primevue/select';
</script>

<template>
  <Select>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </Select>
</template>
