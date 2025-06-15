<script setup>
import { useConfirm } from 'primevue/useconfirm';
import ConfirmDialog from './ConfirmDialog.vue';

const confirm = useConfirm();

const showDeleteConfirm = (title, message, onConfirm) => {
  confirm.require({
    message,
    header: title,
    icon: 'fas fa-exclamation-triangle',
    acceptClass: 'p-button-danger',
    acceptLabel: 'Delete',
    rejectLabel: 'Cancel',
    rejectClass: 'p-button-outlined p-button-secondary',
    accept: onConfirm,
  });
};

defineExpose({
  showDeleteConfirm,
});
</script>

<template>
  <ConfirmDialog>
    <template #message="slotProps">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <font-awesome-icon :icon="['fas', 'exclamation-triangle']" class="text-lg text-yellow-500" />
          <div class="font-medium text-gray-700 text-left">
            {{ slotProps.message.message }}
          </div>
        </div>
        <div class="border-b border-gray-200 mt-4"></div>
      </div>
    </template>
  </ConfirmDialog>
</template>
