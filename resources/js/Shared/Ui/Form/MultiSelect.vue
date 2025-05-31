<script setup>
import MultiSelect from 'primevue/multiselect';
</script>

<template>
  <MultiSelect>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </MultiSelect>
</template>
