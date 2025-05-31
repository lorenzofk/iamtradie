<script setup>
const props = defineProps({
  value: Number,
  boxCheckColor: String,
  checked: Boolean,
});

const emit = defineEmits(['update:modelValue']);

const toggleCheck = value => {
  emit('update:modelValue', !props.checked, value);
};
</script>

<template>
  <div @click="toggleCheck(value)">
    <div v-if="checked">
      <font-awesome-layers class="block">
        <font-awesome-icon :icon="['far', 'square']" :style="{ color: boxCheckColor }" />
        <font-awesome-icon icon="check" transform="shrink-6" :style="{ color: boxCheckColor }" />
      </font-awesome-layers>
    </div>

    <div v-else>
      <font-awesome-layers class="block">
        <font-awesome-icon :icon="['far', 'square']" class="text-gray-500" />
      </font-awesome-layers>
    </div>
  </div>
</template>
