<script setup>
import Card from 'primevue/card';

const { phoneNumber } = defineProps({
    phoneNumber: String
});
</script>

<template>
    <Card class="shadow-2xl border-0 bg-white/95 backdrop-blur">
    <template #content>
        <div class="p-8 text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
        <font-awesome-icon :icon="['fas', 'fa-phone']" class="w-8 h-8 text-white" />
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Your Australian SMS Number</h3>
        <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6 mb-6">
        <div class="text-3xl font-bold text-green-600 mb-2">
            {{ phoneNumber || '+61 2 8123 4567' }}
        </div>
        <p class="text-gray-600">This number is now live and ready to auto-reply with your custom quotes.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div class="bg-blue-50 p-4 rounded-lg">
            <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-blue-600 text-xl mb-2" />
            <p class="font-semibold text-gray-900">AI Trained</p>
            <p class="text-gray-600">Understands customer messages + replies instantly</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <font-awesome-icon :icon="['fas', 'fa-forward']" class="text-purple-600 text-xl mb-2" />
            <p class="font-semibold text-gray-900">SMS Forwarding</p>
            <p class="text-gray-600">Leads sent to your dashboard instantly</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <font-awesome-icon :icon="['fas', 'fa-chart-line']" class="text-green-600 text-xl mb-2" />
            <p class="font-semibold text-gray-900">Lead Insights</p>
            <p class="text-gray-600">Track all quotes and potential job values</p>
        </div>
        </div>
    </div>
    </template>
</Card>
</template>