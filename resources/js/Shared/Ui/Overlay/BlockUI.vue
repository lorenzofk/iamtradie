<script setup>
import BlockUI from 'primevue/blockui';

const props = defineProps({
  blocked: Boolean,
  transparentMask: Boolean,
});

const backgroundColor = props.transparentMask ? '#FFFFFF' : 'rgba(0, 0, 0, 0.3)';
const maskStyle = `background: #000000 url('${asset('/assets/site/images/svg/loading.svg')}') no-repeat 50% 50%; background-color: ${backgroundColor};`;
</script>

<template>
  <BlockUI :blocked :pt:mask:style="maskStyle" unstyled>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </BlockUI>
</template>
