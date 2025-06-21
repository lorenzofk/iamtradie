<script setup>
import Layout from '@/Layouts/App.vue';

defineOptions({
  layout: Layout,
});
</script>

<template>
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4 lg:mb-6 bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
      <div>
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">How It Works</h1>
        <p class="text-sm text-gray-600 mt-1">Understanding PingMate's SMS and voice communication workflows</p>
      </div>
    </div>

    <div class="space-y-4 lg:space-y-8">
      <!-- SMS Workflow Section -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="mb-4 lg:mb-6">
          <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-blue-600" />
            SMS Workflow
          </h2>
          <p class="text-sm text-gray-600 mt-1">Automatic SMS quote generation and response system</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 mb-6">
          <!-- Step 1 -->
          <div class="text-center">
            <div
              class="w-14 h-14 lg:w-16 lg:h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4 relative"
            >
              <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-blue-600 text-lg lg:text-xl" />
              <div
                class="absolute -top-1 -right-1 lg:-top-2 lg:-right-2 w-5 h-5 lg:w-6 lg:h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold"
              >
                1
              </div>
            </div>
            <h3 class="text-sm lg:text-base font-semibold text-gray-900 mb-2">Customer Texts</h3>
            <p class="text-sm text-gray-600">Customer sends quote request to your number</p>
          </div>

          <!-- Step 2 -->
          <div class="text-center">
            <div
              class="w-14 h-14 lg:w-16 lg:h-16 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4 relative"
            >
              <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-purple-600 text-lg lg:text-xl" />
              <div
                class="absolute -top-1 -right-1 lg:-top-2 lg:-right-2 w-5 h-5 lg:w-6 lg:h-6 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold"
              >
                2
              </div>
            </div>
            <h3 class="text-sm lg:text-base font-semibold text-gray-900 mb-2">AI Generates Quote</h3>
            <p class="text-sm text-gray-600">System creates professional quote using your rates</p>
          </div>

          <!-- Step 3 -->
          <div class="text-center">
            <div
              class="w-14 h-14 lg:w-16 lg:h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-3 lg:mb-4 relative"
            >
              <font-awesome-icon :icon="['fas', 'fa-paper-plane']" class="text-green-600 text-lg lg:text-xl" />
              <div
                class="absolute -top-1 -right-1 lg:-top-2 lg:-right-2 w-5 h-5 lg:w-6 lg:h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold"
              >
                3
              </div>
            </div>
            <h3 class="text-sm lg:text-base font-semibold text-gray-900 mb-2">Auto Response</h3>
            <p class="text-sm text-gray-600">Quote sent automatically or saved for review</p>
          </div>
        </div>

        <!-- Instructions -->
        <div class="text-sm text-gray-600 space-y-2">
          <p class="font-medium text-gray-900">How to use your SMS number:</p>
          <ol class="list-decimal list-inside space-y-1 ml-4">
            <li>Share your business number with potential clients.</li>
            <li>They can text you directly for quotes.</li>
            <li>AI will generate responses automatically when you enable auto-send SMS.</li>
          </ol>
        </div>
      </div>

      <!-- Voice Call Workflow Section -->
      <div class="bg-white rounded-xl shadow-sm border-0 p-4 lg:p-6">
        <div class="mb-4 lg:mb-6">
          <h2 class="text-lg lg:text-xl font-semibold text-gray-900 flex items-center gap-2">
            <font-awesome-icon :icon="['fas', 'fa-phone-volume']" class="text-orange-600" />
            Voice Call Workflow
          </h2>
          <p class="text-sm text-gray-600 mt-1">Handle incoming calls with forwarding or voicemail options.</p>
        </div>

        <div class="mb-6 lg:mb-8">
          <!-- Mobile Workflow (Stacked) -->
          <div class="block lg:hidden space-y-4">
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <div
                class="w-10 h-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center flex-shrink-0"
              >
                <font-awesome-icon :icon="['fas', 'fa-phone-alt']" class="text-gray-600" />
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Call Received</p>
                <p class="text-xs text-gray-500">Incoming call to business number</p>
              </div>
            </div>

            <div class="flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-arrow-down']" class="text-gray-400" />
            </div>

            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <div
                class="w-10 h-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center flex-shrink-0"
              >
                <div class="flex items-center justify-center">
                  <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-gray-600 text-xs" />
                  <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-600 text-xs" />
                </div>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Forward or Direct to VM</p>
                <p class="text-xs text-gray-500">Based on your call forwarding settings</p>
              </div>
            </div>

            <div class="flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-arrow-down']" class="text-gray-400" />
            </div>

            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <div
                class="w-10 h-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center flex-shrink-0"
              >
                <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-gray-600" />
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Voicemail</p>
                <p class="text-xs text-gray-500">Customer leaves message</p>
              </div>
            </div>

            <div class="flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-arrow-down']" class="text-gray-400" />
            </div>

            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <div
                class="w-10 h-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center flex-shrink-0"
              >
                <font-awesome-icon :icon="['fas', 'fa-file-text']" class="text-gray-600" />
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Transcript</p>
                <p class="text-xs text-gray-500">AI converts to text</p>
              </div>
            </div>

            <div class="flex items-center justify-center">
              <font-awesome-icon :icon="['fas', 'fa-arrow-down']" class="text-gray-400" />
            </div>

            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <div
                class="w-10 h-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center flex-shrink-0"
              >
                <font-awesome-icon :icon="['fas', 'fa-clipboard-list']" class="text-gray-600" />
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Summary + Quote</p>
                <p class="text-xs text-gray-500">AI generates response</p>
              </div>
            </div>
          </div>

          <!-- Desktop Workflow (Horizontal) -->
          <div
            class="hidden lg:flex flex-col lg:flex-row items-center justify-between gap-4 p-6 bg-gray-50 rounded-lg"
          >
            <!-- Step 1: Call Received -->
            <div class="text-center">
              <div
                class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2"
              >
                <font-awesome-icon :icon="['fas', 'fa-phone-alt']" class="text-gray-600 text-lg" />
              </div>
              <p class="text-sm font-medium text-gray-900">Call Received</p>
            </div>

            <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-400 hidden lg:block" />

            <!-- Step 2: Decision Point -->
            <div class="text-center">
              <div
                class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2"
              >
                <div class="flex items-center justify-center">
                  <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-gray-600 text-lg" />
                  <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-600 text-lg" />
                </div>
              </div>
              <p class="text-sm font-medium text-gray-900">Forward or Direct</p>
            </div>

            <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-400 hidden lg:block" />

            <!-- Step 3: Voicemail -->
            <div class="text-center">
              <div
                class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2"
              >
                <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-gray-600 text-lg" />
              </div>
              <p class="text-sm font-medium text-gray-900">Voicemail</p>
            </div>

            <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-400 hidden lg:block" />

            <!-- Step 4: Transcript -->
            <div class="text-center">
              <div
                class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2"
              >
                <font-awesome-icon :icon="['fas', 'fa-file-text']" class="text-gray-600 text-lg" />
              </div>
              <p class="text-sm font-medium text-gray-900">Transcript</p>
            </div>

            <font-awesome-icon :icon="['fas', 'fa-arrow-right']" class="text-gray-400 hidden lg:block" />

            <!-- Step 5: Summary + Optional Quote -->
            <div class="text-center">
              <div
                class="w-14 h-14 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center mx-auto mb-2"
              >
                <font-awesome-icon :icon="['fas', 'fa-clipboard-list']" class="text-gray-600 text-lg" />
              </div>
              <p class="text-sm font-medium text-gray-900">Summary + Quote</p>
            </div>
          </div>
        </div>

        <!-- Additional Information -->
        <div class="text-sm text-gray-600 space-y-2">
          <p class="font-medium text-gray-900">Voice call handling process:</p>
          <ol class="list-decimal list-inside space-y-1 ml-4">
            <li>Calls come into your business number.</li>
            <li>Based on your settings, calls are either forwarded to your phone or go directly to voicemail.</li>
            <li>If no answer or direct to voicemail, customers hear your custom voicemail message.</li>
            <li>AI transcribes the voicemail and generates a summary.</li>
            <li>Optionally, AI can automatically send an SMS quote response based on the voicemail content.</li>
          </ol>
        </div>
      </div>

      <!-- Additional Help Section -->
      <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 lg:p-6">
        <div class="flex items-start gap-3">
          <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <font-awesome-icon :icon="['fas', 'fa-lightbulb']" class="text-blue-600" />
          </div>
          <div>
            <h3 class="text-sm font-semibold text-gray-900 mb-2">Tips for Best Results</h3>
            <ul class="text-sm text-gray-600 space-y-1">
              <li>• Keep your pricing information up to date in Settings for accurate quotes</li>
              <li>• Customize your voicemail message to encourage detailed descriptions of work needed</li>
              <li>• Review and adjust your AI response tone to match your business style</li>
              <li>• Monitor your quote usage to stay within your monthly limits</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template> 