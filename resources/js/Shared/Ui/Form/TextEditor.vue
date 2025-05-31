<script setup>
import { defineModel, ref } from 'vue';
import Editor from 'primevue/editor';

const model = defineModel();
const editor = ref(null);

/**
 * Formats allowed by the editor, this is separate to the toolbar buttons
 * as it also affects the content that can be pasted into the editor.
 */
const formats = ['bold', 'italic', 'underline', 'align', 'list', 'link'];

const onLoad = ({ instance }) => {
  editor.value = instance;
};
</script>

<template>
  <Editor :formats="formats" v-model="model" @load="onLoad">
    <template v-slot:toolbar>
      <span class="ql-formats">
        <button v-tooltip.bottom="'Bold'" class="ql-bold"></button>
        <button v-tooltip.bottom="'Italic'" class="ql-italic"></button>
        <button v-tooltip.bottom="'Underline'" class="ql-underline"></button>
      </span>
      <span class="ql-formats">
        <button v-tooltip.bottom="'Ordered List'" class="ql-list" value="ordered"></button>
        <button v-tooltip.bottom="'Unordered List'" class="ql-list" value="bullet"></button>
        <select v-tooltip.bottom="'Alignment'" class="ql-align"></select>
      </span>
      <span class="ql-formats">
        <button v-tooltip.bottom="'Link'" class="ql-link"></button>
        <button v-tooltip.bottom="'Remove Format'" class="ql-clean"></button>
      </span>
    </template>
    <template v-for="(_, name) in $slots" v-slot:[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
  </Editor>
</template>

<style scoped>
:deep(.p-editor-content) p {
  @apply text-base;
  @apply font-inter;
}
</style>
