<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import App from '@/Layouts/App.vue';
import Button from '@/Shared/Ui/Button/Button.vue';
import { useToast } from '@Shared/Ui/Hooks/useToast';

const { showToast } = useToast();

defineOptions({
  layout: App
});

const props = defineProps({
  subscription: Object,
  invoices: Array,
});

const user = usePage().props.auth?.user;

const isLoading = ref(false);
const showCancelConfirm = ref(false);

const cancelForm = useForm('post', route('billing.cancel'), {});
const resumeForm = useForm('post', route('billing.resume'), {});
const manageForm = useForm('post', route('billing.manage'), {});
const subscribeForm = useForm('post', route('billing.subscribe'), {
  plan: 'pro'
});

const formatCurrency = (amount, currency = 'aud') => {
  return new Intl.NumberFormat('en-AU', {
    style: 'currency',
    currency: currency.toUpperCase(),
  }).format(amount / 100);
};

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-AU', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
};

const getStatusBadgeClass = (status) => {
  const classes = {
    active: 'bg-green-100 text-green-800',
    canceled: 'bg-red-100 text-red-800',
    past_due: 'bg-yellow-100 text-yellow-800',
    unpaid: 'bg-red-100 text-red-800'
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const manageSubscription = () => {
  window.location.href = route('billing.manage');
};

const cancelSubscription = () => {
  isLoading.value = true;
  cancelForm.submit({
    preserveScroll: true,
    onSuccess: () => {
      showToast('success', 'Subscription cancelled successfully.');
      showCancelConfirm.value = false;
      isLoading.value = false;
    },
    onError: (error) => {
      showToast('error', error.message || 'Failed to cancel subscription.');
      isLoading.value = false;
    },
  });
};

const resumeSubscription = () => {
  isLoading.value = true;
  resumeForm.submit({
    preserveScroll: true,
    onSuccess: () => {
      showToast('success', 'Subscription resumed successfully.');
      isLoading.value = false;
    },
    onError: (error) => {
      showToast('error', error.message || 'Failed to resume subscription.');
      isLoading.value = false;
    },
  });
};

const subscribeToProPlan = () => {
  isLoading.value = true;
  subscribeForm.submit({
    preserveScroll: true,
    onSuccess: (page) => {
      if (page.props.checkoutUrl) {
        window.location.href = page.props.checkoutUrl;
      }
      isLoading.value = false;
    },
    onError: (error) => {
      showToast('error', error.message || 'Failed to start subscription.');
      isLoading.value = false;
    },
  });
};

const openInvoiceUrl = (url) => {
  if (typeof window !== 'undefined' && url) {
    window.open(url, '_blank');
  }
};
</script>

<template>
  <div class="max-w-6xl mx-auto py-4 lg:py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4 lg:mb-6 bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
      <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Billing</h1>
    </div>

    <!-- Current Plan Card -->
    <div class="bg-white shadow-sm rounded-xl border-0 p-4 lg:p-6 mb-4 lg:mb-6">
      <div class="mb-4 lg:mb-6">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
          <font-awesome-icon :icon="['fas', 'fa-crown']" class="text-yellow-500" />
          Current Plan
        </h2>
        <p class="text-sm text-gray-600 mt-1">Manage your subscription and billing details</p>
      </div>

      <!-- Active Subscription -->
      <div v-if="subscription" class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">{{ subscription.plan?.nickname || 'Pro Plan' }}</h3>
            <p class="text-gray-600">
              {{ formatCurrency(subscription.plan?.amount || 2900) }} / {{ subscription.plan?.interval || 'month' }}
            </p>
          </div>
          <div class="flex items-center gap-2 flex-wrap">
            <span 
              class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
              :class="getStatusBadgeClass(subscription.status)"
            >
              {{ subscription.status.charAt(0).toUpperCase() + subscription.status.slice(1) }}
            </span>
            <span 
              v-if="subscription.cancel_at_period_end"
              class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800"
            >
              Ending Soon
            </span>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 pt-4 border-t border-gray-200">
          <div class="bg-gray-50 p-3 rounded-lg lg:bg-transparent lg:p-0">
            <p class="text-sm font-medium text-gray-500">
              {{ subscription.cancel_at_period_end ? 'Service ends' : 'Next billing date' }}
            </p>
            <p class="text-sm text-gray-900 font-medium">{{ formatDate(subscription.current_period_end) }}</p>
          </div>
          <div class="bg-gray-50 p-3 rounded-lg lg:bg-transparent lg:p-0">
            <p class="text-sm font-medium text-gray-500">Usage this month</p>
            <p class="text-sm text-gray-900 font-medium">
              {{ user?.quotes_used || 47 }} / {{ user?.quotes_limit || 100 }} quotes
            </p>
          </div>
          <div class="bg-gray-50 p-3 rounded-lg lg:bg-transparent lg:p-0">
            <p class="text-sm font-medium text-gray-500">Plan status</p>
            <p class="text-sm text-gray-900 font-medium">
              {{ subscription.cancel_at_period_end ? 'Cancelled - Active until end date' : 'Active & Renewing' }}
            </p>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 pt-4">
          <Button 
            outlined
            size="small"
            :icon="['fas', 'fa-credit-card']"
            label="Manage Subscription"
            @click="manageSubscription"
            :loading="manageForm.processing"
            class="w-full sm:w-auto"
          />
          
          <Button 
            v-if="subscription.status === 'active' && !subscription.cancel_at_period_end"
            outlined
            size="small"
            :icon="['fas', 'fa-times']"
            label="Cancel Subscription"
            @click="showCancelConfirm = true"
            class="text-red-600 border-red-300 hover:bg-red-50 w-full sm:w-auto"
          />
          
          <Button 
            v-if="subscription.cancel_at_period_end"
            size="small"
            :icon="['fas', 'fa-undo']"
            label="Resume Subscription"
            @click="resumeSubscription"
            :loading="resumeForm.processing"
            class="w-full sm:w-auto"
          />
        </div>

        <div v-if="subscription.cancel_at_period_end" class="mt-4 p-4 bg-orange-50 border border-orange-200 rounded-lg">
          <div class="flex items-start gap-3">
            <font-awesome-icon :icon="['fas', 'fa-exclamation-triangle']" class="text-orange-600 mt-0.5 flex-shrink-0" />
            <div>
              <p class="text-sm font-medium text-orange-800 mb-1">
                Subscription Cancelled
              </p>
              <p class="text-sm text-orange-700">
                Your subscription is cancelled but remains active until {{ formatDate(subscription.current_period_end) }}. 
                You can resume anytime before this date to continue service without interruption.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- No Subscription -->
      <div v-else class="text-center py-6 lg:py-8">
        <font-awesome-icon :icon="['fas', 'fa-zap']" class="text-gray-300 text-4xl lg:text-5xl mb-4" />
        <h3 class="text-lg font-medium text-gray-900 mb-2">No Active Subscription</h3>
        <p class="text-gray-500 mb-6">
          Subscribe to unlock unlimited quotes and premium features.
        </p>
        
        <div class="max-w-md mx-auto">
          <div class="bg-white border-2 border-blue-500 rounded-lg p-4 lg:p-6">
            <div class="text-center mb-4">
              <h4 class="text-lg font-semibold text-gray-900">{{ subscription.plan?.nickname || 'Pro Plan' }}</h4>
              <p class="text-sm text-gray-600">Perfect for growing businesses</p>
              <div class="text-2xl lg:text-3xl font-bold text-gray-900 mt-2">
                $29<span class="text-base lg:text-lg font-normal text-gray-600">/month</span>
              </div>
            </div>
            
            <ul class="space-y-2 text-sm mb-6">
              <li class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 flex-shrink-0" />
                Unlimited AI quotes
              </li>
              <li class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 flex-shrink-0" />
                SMS integration
              </li>
              <li class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 flex-shrink-0" />
                Custom embed forms
              </li>
              <li class="flex items-center gap-2">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 flex-shrink-0" />
                Email notifications
              </li>
            </ul>
            
            <Button 
              size="small"
              label="Subscribe Now"
              @click="subscribeToProPlan"
              :loading="subscribeForm.processing"
              class="w-full"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Billing History Card -->
    <div class="bg-white shadow-sm rounded-xl border-0 p-4 lg:p-6">
      <div class="mb-4 lg:mb-6">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
          <font-awesome-icon :icon="['fas', 'fa-history']" class="text-blue-500" />
          Billing History
        </h2>
        <p class="text-sm text-gray-600 mt-1">View and download your past invoices</p>
      </div>

      <div v-if="invoices && invoices.length > 0" class="space-y-3 lg:space-y-4">
        <div 
          v-for="invoice in invoices" 
          :key="invoice.id"
          class="flex flex-col lg:flex-row lg:items-center justify-between p-4 border border-gray-200 rounded-lg gap-4"
        >
          <div class="flex items-center gap-3 lg:gap-4">
            <div class="flex items-center justify-center w-10 h-10 rounded-full flex-shrink-0"
                 :class="invoice.status === 'paid' ? 'bg-green-100' : 'bg-red-100'">
              <font-awesome-icon 
                :icon="invoice.status === 'paid' ? ['fas', 'fa-check'] : ['fas', 'fa-times']"
                :class="invoice.status === 'paid' ? 'text-green-600' : 'text-red-600'"
              />
            </div>
            <div class="min-w-0 flex-1">
              <p class="font-medium text-gray-900 text-sm lg:text-base">
                {{ formatCurrency(invoice.amount_paid) }}
              </p>
              <p class="text-sm text-gray-500">
                {{ formatDate(invoice.created) }} • {{ invoice.status }}
              </p>
            </div>
          </div>
          
          <div class="flex gap-2 flex-col sm:flex-row lg:flex-shrink-0">
            <Button 
              size="small"
              outlined
              :icon="['fas', 'fa-download']"
              label="Download"
              @click="openInvoiceUrl(invoice.invoice_pdf)"
              class="w-full sm:w-auto"
            />
            <Button 
              size="small"
              outlined
              :icon="['fas', 'fa-external-link-alt']"
              label="View"
              @click="openInvoiceUrl(invoice.hosted_invoice_url)"
              class="w-full sm:w-auto"
            />
          </div>
        </div>
      </div>
      <div v-else class="text-center py-6 lg:py-8">
        <div class="flex flex-col items-center">
          <font-awesome-icon :icon="['fas', 'fa-file-invoice']" class="text-gray-300 text-4xl lg:text-5xl mb-4" />
          <h3 class="text-lg font-medium text-gray-900 mb-2">No invoices found</h3>
          <p class="text-gray-500">
            You have no invoices yet.
          </p>
        </div>
      </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div v-if="showCancelConfirm" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
      <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full mx-4">
        <div class="text-center mb-6">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <font-awesome-icon :icon="['fas', 'fa-exclamation-triangle']" class="text-red-600" />
          </div>
          <h3 class="text-lg font-medium text-gray-900">Cancel Subscription</h3>
          <p class="text-sm text-gray-500 mt-2">
            Are you sure you want to cancel your subscription? You'll continue to have access until your current billing period ends.
          </p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
          <Button 
            outlined
            size="small"
            label="Keep Subscription"
            @click="showCancelConfirm = false"
            class="flex-1"
            :disabled="isLoading"
          />
          <Button 
            size="small"
            label="Cancel Subscription"
            @click="cancelSubscription"
            :loading="cancelForm.processing"
            class="flex-1 bg-red-600 hover:bg-red-700 border-red-600"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Additional styles if needed */
</style>