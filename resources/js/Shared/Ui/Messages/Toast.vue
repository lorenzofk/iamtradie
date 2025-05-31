<script setup>
import Toast from 'primevue/toast';
</script>

<template>
  <Toast pt:root:style="top: 5px;right: 10px;z-index:9999;" :autoZIndex="false">
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </Toast>
</template>
