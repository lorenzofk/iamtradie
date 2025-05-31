<script setup>
import InputNumber from 'primevue/inputnumber';
</script>

<template>
  <InputNumber mode="currency" currency="AUD" currencyDisplay="symbol" :minFractionDigits="2" :maxFractionDigits="2" />
</template>
