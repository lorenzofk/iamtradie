<script setup>
import DatePicker from 'primevue/datepicker';

defineOptions({
  name: 'DatePicker',
});
</script>

<template>
  <DatePicker>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </DatePicker>
</template>
