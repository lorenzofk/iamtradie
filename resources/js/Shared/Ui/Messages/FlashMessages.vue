<template>
  <div style="margin: -1rem 0" v-if="hasFlash || hasErrors">
    <!-- Success -->
    <div
      v-if="$page.props.flash.success"
      class="nb-alert nb-alert-success tw-flex tw-items-center tw-justify-between !tw-rounded-none"
    >
      <div class="tw-flex tw-items-center">
        <font-awesome-icon :icon="['far', 'check-circle']" class="tw-mr-2 tw-text-lg" />
        <div class="tw-py-2">{{ $page.props.flash.success }}</div>
      </div>
      <button type="button" class="tw-ml-2 tw-p-2" @click="hide()">
        <font-awesome-icon :icon="['fas', 'times']" />
      </button>
    </div>

    <!-- Error -->
    <div
      v-if="$page.props.flash.error || hasErrors"
      class="nb-alert nb-alert-danger tw-flex tw-items-center tw-justify-between !tw-rounded-none"
    >
      <div class="tw-flex tw-items-center">
        <div v-if="$page.props.flash.error" class="tw-py-2">
          <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="tw-mr-2 tw-text-lg" />
          <span v-html="$page.props.flash.error"></span>
        </div>
        <div v-else class="tw-flex tw-items-center tw-gap-2 tw-py-2 tw-font-medium">
          <div>
            <font-awesome-icon :icon="['fas', 'exclamation-circle']" class="tw-mr-2 tw-text-lg" />
          </div>
          <div>
            <ul>
              <li v-for="(error, index) in $page.props.errors" :key="index">
                <span v-html="error"></span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <button type="button" class="tw-ml-2 tw-p-2" @click="hide">
        <font-awesome-icon :icon="['fas', 'times']" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { watch, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

let hasFlash = ref(false);
let hasErrors = ref(false);

const hide = () => {
  hasFlash.value = false;
  hasErrors.value = false;
};

watch(
  () => usePage().props?.flash,
  function (newValue) {
    hasFlash.value = newValue.error || newValue.success;
  },
  { deep: true }
);

watch(
  () => usePage().props?.errors,
  function (newValue) {
    hasErrors.value = !!Object.keys(newValue).length;
  },
  { deep: true }
);
</script>
