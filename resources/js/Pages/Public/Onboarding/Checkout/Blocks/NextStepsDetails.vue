<script setup>
import Card from 'primevue/card';
import Button from '@/Shared/Ui/Button/Button.vue';
</script>

<template>
  <Card class="shadow-2xl border-0 bg-white/95 backdrop-blur">
    <template #content>
      <div class="p-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">What happens next?</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <div class="space-y-6">
            <div
              class="flex items-start hover:scale-[1.02] hover:shadow-md transition duration-200 ease-in-out rounded-lg p-4 hover:bg-blue-50"
            >
              <div
                class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0"
              >
                <span class="text-sm font-bold">1</span>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900">Check your inbox</h4>
                <p class="text-gray-600 text-sm">
                  We've sent detailed setup instructions, login credentials, and your getting started guide.
                </p>
              </div>
            </div>

            <div
              class="flex items-start hover:scale-[1.02] hover:shadow-md transition duration-200 ease-in-out rounded-lg p-4 hover:bg-blue-50"
            >
              <div
                class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0"
              >
                <span class="text-sm font-bold">2</span>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900">Start sharing your number</h4>
                <p class="text-gray-600 text-sm">Add your new SMS number to ads, flyers, or your site</p>
              </div>
            </div>

            <div
              class="flex items-start hover:scale-[1.02] hover:shadow-md transition duration-200 ease-in-out rounded-lg p-4 hover:bg-blue-50"
            >
              <div
                class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0"
              >
                <span class="text-sm font-bold">3</span>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900">Monitor & edit quotes</h4>
                <p class="text-gray-600 text-sm">Check your dashboard to tweak or review any AI responses</p>
              </div>
            </div>
          </div>

          <div class="space-y-6">
            <div
              class="flex items-start hover:scale-[1.02] hover:shadow-md transition duration-200 ease-in-out rounded-lg p-4 hover:bg-green-50"
            >
              <div
                class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0"
              >
                <span class="text-sm font-bold">4</span>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900">Update preferences</h4>
                <p class="text-gray-600 text-sm">Change tone, pricing or auto-send options anytime</p>
              </div>
            </div>

            <div
              class="flex items-start hover:scale-[1.02] hover:shadow-md transition duration-200 ease-in-out rounded-lg p-4 hover:bg-green-50"
            >
              <div
                class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0"
              >
                <span class="text-sm font-bold">5</span>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900">Grow your business</h4>
                <p class="text-gray-600 text-sm">Let AI handle the quoting while you focus on the job</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Separator -->
        <hr class="border-gray-200 mb-6" />

        <!-- Support section -->
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200 text-center">
          <font-awesome-icon :icon="['fas', 'fa-headset']" class="text-purple-600 text-2xl mb-3" />
          <h4 class="font-bold text-purple-900 mb-2">Need help getting started?</h4>
          <p class="text-purple-700 text-sm mb-4">
            Our support team is here to help you make the most of your AI assistant
          </p>
          <Button
            class="!bg-purple-600 hover:!bg-purple-700 text-white"
            :icon="['fas', 'fa-envelope']"
            label="Contact Support"
          />
        </div>
      </div>
    </template>
  </Card>
</template>
