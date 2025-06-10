<script setup>
import { Button } from 'primevue';
import { ref, onMounted } from 'vue';

// Animation states
const currentStep = ref(0);
const isAnimating = ref(false);
const showCallSummary = ref(false);
const showAutoReply = ref(false);

// Simulate the call workflow animation
const startWorkflowAnimation = () => {
  isAnimating.value = true;
  currentStep.value = 0;
  showCallSummary.value = false;
  showAutoReply.value = false;
  
  const steps = [
    () => { currentStep.value = 1; }, // Call received
    () => { currentStep.value = 2; }, // Forward attempt
    () => { currentStep.value = 3; }, // Voicemail
    () => { currentStep.value = 4; }, // Transcription
    () => { showCallSummary.value = true; }, // Summary to you
    () => { showAutoReply.value = true; isAnimating.value = false; } // Auto-reply to customer
  ];
  
  steps.forEach((step, index) => {
    setTimeout(step, (index + 1) * 1000);
  });
};

onMounted(() => {
  setTimeout(startWorkflowAnimation, 1000);
});

const smsExamples = [
  {
    icon: 'bolt',
    title: 'SMS Response',
    subtitle: 'Electrician Example',
    customerMessage: 'Need power points installed in new kitchen',
    aiResponse: 'G\'day! Power point install typically $380-$520 incl. callout. Takes 2-3 hours. Happy to give you a proper quote! Cheers, Dave.',
    responseTime: '2 seconds'
  },
  {
    icon: 'robot',
    title: 'SMS Response', 
    subtitle: 'Plumber Example',
    customerMessage: 'Hot water system leaking, need urgent repair',
    aiResponse: 'No worries mate! Hot water repairs $420-$680 incl. callout. Can come out tonight if urgent. Give us a bell! - Mike',
    responseTime: '3 seconds'
  },
  {
    icon: 'wand-sparkles',
    title: 'SMS Response',
    subtitle: 'Cleaner Example', 
    customerMessage: 'Bond clean for 3 bedroom house next week?',
    aiResponse: 'Hi there! 3BR bond clean typically $680-$950. Includes all rooms, kitchen, bathrooms. Guaranteed to pass inspection! - Sarah',
    responseTime: '4 seconds'
  }
];
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-4xl sm:text-5xl font-extrabold text-slate-900 mb-6">
          Beat Competitors with Lightning-Fast SMS Replies
        </h2>
        <p class="text-xl text-slate-600 max-w-4xl mx-auto">
          Customer texts you at 8:30 PM? AI replies instantly with a professional quote using your rates. Weekend inquiry? No worries, you're always first to respond.
        </p>
      </div>

      <!-- SMS Examples Row -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
        <div 
          v-for="(example, index) in smsExamples" 
          :key="index"
          class="cursor-pointer bg-white rounded-2xl p-6 shadow-xl border border-sky-100 hover:scale-105 transition-transform duration-300"
        >
          <div class="text-center mb-6">
            <div class="bg-sky-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
              <font-awesome-icon :icon="['fas', example.icon]" class="text-sky-600 text-2xl" />
            </div>
            <h3 class="text-xl font-bold text-slate-900">{{ example.title }}</h3>
            <p class="text-sm text-slate-600">{{ example.subtitle }}</p>
          </div>
          
          <div class="bg-gray-50 rounded-xl p-4 space-y-3">
            <!-- Customer Message -->
            <div class="flex justify-start">
              <div class="bg-gray-200 rounded-2xl rounded-bl-md px-3 py-2 max-w-xs">
                <p class="text-sm text-gray-800">{{ example.customerMessage }}</p>
                <div class="text-xs text-gray-500 mt-1">{{ index === 0 ? '2:15 PM' : index === 1 ? '9:22 PM' : '4:45 PM' }}</div>
              </div>
            </div>
            
            <!-- Typing Indicator -->
            <div class="flex justify-end">
              <div class="bg-gray-300 rounded-2xl rounded-br-md px-4 py-2">
                <div class="flex space-x-1">
                  <div class="w-1.5 h-1.5 bg-gray-600 rounded-full animate-bounce"></div>
                  <div class="w-1.5 h-1.5 bg-gray-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                  <div class="w-1.5 h-1.5 bg-gray-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
              </div>
            </div>
            
            <!-- AI Response -->
            <div class="flex justify-end">
              <div class="bg-blue-500 rounded-2xl rounded-br-md px-3 py-2 max-w-xs">
                <p class="text-sm text-white">{{ example.aiResponse }}</p>
                <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                  <span>{{ index === 0 ? '2:15 PM' : index === 1 ? '9:22 PM' : '4:45 PM' }}</span>
                  <div class="ml-1 text-white">✓✓</div>
                </div>
              </div>
            </div>
            
            <div class="flex justify-center">
              <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                ⚡ Replied in {{ example.responseTime }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Interactive Call Workflow Section -->
      <div class="bg-white rounded-3xl p-8 shadow-2xl border border-sky-100 mb-16">
        <div class="text-center mb-12">
          <h3 class="text-3xl font-bold text-slate-900 mb-4">Missed Call Handling</h3>
          <p class="text-lg text-slate-600 mb-6">Never miss another opportunity</p>
          <button 
            @click="startWorkflowAnimation"
            :disabled="isAnimating"
            class="inline-flex items-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg transition-colors duration-200"
            :class="{ 'opacity-50 cursor-not-allowed': isAnimating }"
          >
            <font-awesome-icon :icon="['fas', 'fa-play']" class="mr-2" />
            {{ isAnimating ? 'Watch the Magic...' : 'See How It Works' }}
          </button>
        </div>

        <!-- Visual Workflow -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <!-- Left Side: Flow Diagram -->
          <div class="space-y-6">
            <!-- Step 1: Call Received -->
            <div class="flex items-center gap-4 p-4 rounded-xl transition-all duration-300"
                 :class="currentStep >= 1 ? 'bg-sky-50 border-2 border-sky-200' : 'bg-gray-50 border-2 border-gray-200'">
              <div class="w-12 h-12 rounded-full flex items-center justify-center transition-colors duration-300"
                   :class="currentStep >= 1 ? 'bg-sky-500 text-white' : 'bg-gray-300 text-gray-600'">
                <font-awesome-icon :icon="['fas', 'fa-phone-alt']" />
              </div>
              <div>
                <h4 class="font-semibold text-slate-800">Customer calls your business number</h4>
                <p class="text-sm text-slate-600">Looks local with your own Aussie number</p>
              </div>
            </div>

            <!-- Step 2: Forward Attempt -->
            <div class="flex items-center gap-4 p-4 rounded-xl transition-all duration-300"
                 :class="currentStep >= 2 ? 'bg-blue-50 border-2 border-blue-200' : 'bg-gray-50 border-2 border-gray-200'">
              <div class="w-12 h-12 rounded-full flex items-center justify-center transition-colors duration-300"
                   :class="currentStep >= 2 ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600'">
                <font-awesome-icon :icon="['fas', 'fa-mobile-alt']" />
              </div>
              <div>
                <h4 class="font-semibold text-slate-800">Forward to your mobile</h4>
                <div class="flex items-center gap-2">
                  <p class="text-sm text-slate-600">Ring for 20 seconds</p>
                  <span class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded-full font-medium">Optional</span>
                </div>
              </div>
            </div>

            <!-- Step 3: Voicemail -->
            <div class="flex items-center gap-4 p-4 rounded-xl transition-all duration-300"
                 :class="currentStep >= 3 ? 'bg-purple-50 border-2 border-purple-200' : 'bg-gray-50 border-2 border-gray-200'">
              <div class="w-12 h-12 rounded-full flex items-center justify-center transition-colors duration-300"
                   :class="currentStep >= 3 ? 'bg-purple-500 text-white' : 'bg-gray-300 text-gray-600'">
                <font-awesome-icon :icon="['fas', 'fa-voicemail']" />
              </div>
              <div>
                <h4 class="font-semibold text-slate-800">Custom voicemail plays if unanswered</h4>
                <p class="text-sm text-slate-600">You can define your custom message</p>
              </div>
            </div>

            <!-- Step 4: Transcription -->
            <div class="flex items-center gap-4 p-4 rounded-xl transition-all duration-300"
                 :class="currentStep >= 4 ? 'bg-green-50 border-2 border-green-200' : 'bg-gray-50 border-2 border-gray-200'">
              <div class="w-12 h-12 rounded-full flex items-center justify-center transition-colors duration-300"
                   :class="currentStep >= 4 ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600'">
                <font-awesome-icon :icon="['fas', 'fa-file-text']" />
              </div>
              <div>
                <h4 class="font-semibold text-slate-800">Voicemail transcribed instantly</h4>
                <p class="text-sm text-slate-600">AI converts speech to text in seconds</p>
              </div>
            </div>
          </div>

          <!-- Right Side: Live Results -->
          <div class="space-y-6">
            <!-- Summary to You -->
            <div class="bg-white rounded-xl border-2 p-6 transition-all duration-500"
                 :class="showCallSummary ? 'border-sky-200 shadow-lg scale-105' : 'border-gray-200 opacity-50'">
              <div class="flex items-center gap-3 mb-4">
                <div class="bg-sky-100 rounded-full w-12 h-12 flex items-center justify-center">
                  <font-awesome-icon :icon="['fas', 'fa-user-tie']" class="text-sky-600" />
                </div>
                <div>
                  <h4 class="font-bold text-slate-800">Smart SMS sent to you</h4>
                  <p class="text-sm text-slate-600">Your AI agent summarises everything</p>
                </div>
              </div>

              <div class="bg-gray-50 rounded-lg p-4" v-show="showCallSummary">
                <div class="flex justify-end">
                  <div class="bg-blue-500 rounded-2xl rounded-br-md px-3 py-2 max-w-xs">
                    <p class="text-sm text-white">
                      📞 Missed Call from 0482 123 456<br>
                      💬 Fuse box tripping — wants someone this week<br>
                      💰 Est. Value: $320–$450<br>
                      ⚡ Urgency: Medium
                    </p>
                    <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                      <span>10:18 AM</span>
                      <div class="ml-1 text-white">✓✓</div>
                    </div>
                  </div>
                </div>
                <div class="flex justify-center mt-3">
                  <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                    🧠 Summary sent in 15 seconds
                  </span>
                </div>
              </div>
            </div>

            <!-- Auto-Reply to Customer -->
            <div class="bg-white rounded-xl border-2 p-6 transition-all duration-500"
                 :class="showAutoReply ? 'border-green-200 shadow-lg scale-105' : 'border-gray-200 opacity-50'">
              <div class="flex items-center gap-3 mb-4">
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center">
                  <font-awesome-icon :icon="['fas', 'fa-reply']" class="text-green-600" />
                </div>
                <div>
                  <h4 class="font-bold text-slate-800">Auto-reply sent to caller</h4>
                  <div class="flex items-center gap-2">
                    <p class="text-sm text-slate-600">Professional quote based on your pricing</p>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-600 rounded-full font-medium">Optional</span>
                  </div>
                </div>
              </div>

              <div class="bg-gray-50 rounded-lg p-4" v-show="showAutoReply">
                <div class="flex justify-end">
                  <div class="bg-blue-500 rounded-2xl rounded-br-md px-3 py-2 max-w-xs">
                    <p class="text-sm text-white">Thanks for calling! Fuse box issues typically $320-450 incl. callout. I'll check your message and get back shortly. If urgent, reply here. - Dave</p>
                    <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                      <span>10:19 AM</span>
                      <div class="ml-1 text-white">✓✓</div>
                    </div>
                  </div>
                </div>
                <div class="flex justify-center mt-3">
                  <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                    🤖 Auto-Reply Sent Instantly
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom CTA -->
      <div class="text-center">
        <div class="bg-gradient-to-r from-sky-50 to-blue-50 rounded-2xl p-8 border border-sky-100">
          <h3 class="text-2xl font-bold text-slate-800 mb-4">
            Ready to Never Miss Another Lead?
          </h3>
          <p class="text-slate-600 mb-6">
            Join 100+ Australian tradies who capture every opportunity with PingMate
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <Button unstyled class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
              <font-awesome-icon :icon="['fas', 'fa-rocket']" class="mr-2" />
              Get Started Now
            </Button>
          </div>
        </div>
      </div>
    </div>
</template>