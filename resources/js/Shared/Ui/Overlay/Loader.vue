<script setup>
import { useLoader } from '@Shared/Ui/Hooks/useLoader';

const { loading } = useLoader();

const loaderUrl = `url('${asset('/assets/site/images/svg/loading.svg')}')`;
</script>

<template>
  <div class="loading" v-if="loading"></div>
</template>

<style scoped>
.loading {
  height: 100%;
  width: 100%;
  position: fixed;
  left: 0px;
  top: 0px;
  z-index: 6001;
  background: #fff v-bind(loaderUrl) no-repeat 50% 50%;
}
</style>
