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
    <!-- SMS Section -->
    <div class="text-center mb-12 sm:mb-16">
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-4 sm:mb-6">
        Beat Competitors with Lightning-Fast SMS Replies
      </h2>
      <p class="text-base sm:text-lg lg:text-xl text-slate-600 max-w-4xl mx-auto">
        Customer texts you at 8:30 PM? AI replies instantly with a professional quote using your rates. Weekend inquiry? No worries, you're always first to respond.
      </p>
    </div>

    <!-- SMS Examples Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-16 sm:mb-20">
      <div 
        v-for="(example, index) in smsExamples" 
        :key="index"
        class="cursor-pointer bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-xl border border-sky-100 hover:scale-105 transition-transform duration-300"
      >
        <div class="text-center mb-4 sm:mb-6">
          <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
            <font-awesome-icon :icon="['fas', example.icon]" class="text-sky-600 text-lg sm:text-2xl" />
          </div>
          <h3 class="text-lg sm:text-xl font-bold text-slate-900">{{ example.title }}</h3>
          <p class="text-xs sm:text-sm text-slate-600">{{ example.subtitle }}</p>
        </div>
        
        <div class="bg-gray-50 rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
          <!-- Customer Message -->
          <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
              <p class="text-xs sm:text-sm text-gray-800">{{ example.customerMessage }}</p>
              <div class="text-xs text-gray-500 mt-1">{{ index === 0 ? '2:15 PM' : index === 1 ? '9:22 PM' : '4:45 PM' }}</div>
            </div>
          </div>
          
          <!-- Typing Indicator -->
          <div class="flex justify-end">
            <div class="bg-gray-300 rounded-2xl rounded-br-md px-3 sm:px-4 py-1.5 sm:py-2">
              <div class="flex space-x-1">
                <div class="w-1 h-1 sm:w-1.5 sm:h-1.5 bg-gray-600 rounded-full animate-bounce"></div>
                <div class="w-1 h-1 sm:w-1.5 sm:h-1.5 bg-gray-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-1 h-1 sm:w-1.5 sm:h-1.5 bg-gray-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
              </div>
            </div>
          </div>
          
          <!-- AI Response -->
          <div class="flex justify-end">
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
              <p class="text-xs sm:text-sm text-white">{{ example.aiResponse }}</p>
              <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                <span>{{ index === 0 ? '2:15 PM' : index === 1 ? '9:22 PM' : '4:45 PM' }}</span>
                <div class="ml-1 text-white">✓✓</div>
              </div>
            </div>
          </div>
          
          <div class="flex justify-center">
            <span class="bg-green-100 text-green-800 px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
              ⚡ Replied in {{ example.responseTime }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Call Section - Full Prominence -->
    <div class="text-center mb-12 sm:mb-16">
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-4 sm:mb-6">
        Smart Missed Call Handling
      </h2>
      <p class="text-base sm:text-lg lg:text-xl text-slate-600 max-w-4xl mx-auto mb-6 sm:mb-8">
        Never miss another opportunity. When customers call and you can't answer, AI handles everything — transcribes voicemails, sends you smart summaries, and optionally replies to customers with professional quotes.
      </p>
      
      <button 
        @click="startWorkflowAnimation"
        :disabled="isAnimating"
        class="cursor-pointer inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 text-base sm:text-lg"
        :class="{ 'opacity-50 cursor-not-allowed': isAnimating }"
      >
        <font-awesome-icon :icon="['fas', 'fa-play']" class="mr-2 sm:mr-3 text-lg sm:text-xl" />
        {{ isAnimating ? 'Watch the Magic...' : 'See How It Works' }}
      </button>
    </div>

    <!-- Interactive Call Workflow -->
    <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-12 shadow-2xl border border-sky-100 mb-16 sm:mb-20">
      <!-- Visual Workflow -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-10 lg:gap-12">
        <!-- Left Side: Flow Diagram -->
        <div class="space-y-4 sm:space-y-6">
          <!-- Step 1: Call Received -->
          <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-6 rounded-xl transition-all duration-300"
               :class="currentStep >= 1 ? 'bg-sky-50 border-2 border-sky-200 shadow-md' : 'bg-gray-50 border-2 border-gray-200'">
            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full flex items-center justify-center transition-colors duration-300 flex-shrink-0"
                 :class="currentStep >= 1 ? 'bg-sky-500 text-white shadow-lg' : 'bg-gray-300 text-gray-600'">
              <font-awesome-icon :icon="['fas', 'fa-phone-alt']" class="text-sm sm:text-lg" />
            </div>
            <div class="min-w-0 flex-1">
              <h4 class="text-base sm:text-lg font-bold text-slate-800">Customer calls your business number</h4>
              <p class="text-xs sm:text-sm text-slate-600">Looks local with your own Aussie number</p>
            </div>
          </div>

          <!-- Step 2: Forward Attempt -->
          <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-6 rounded-xl transition-all duration-300"
               :class="currentStep >= 2 ? 'bg-blue-50 border-2 border-blue-200 shadow-md' : 'bg-gray-50 border-2 border-gray-200'">
            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full flex items-center justify-center transition-colors duration-300 flex-shrink-0"
                 :class="currentStep >= 2 ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-300 text-gray-600'">
              <font-awesome-icon :icon="['fas', 'fa-mobile-alt']" class="text-sm sm:text-lg" />
            </div>
            <div class="min-w-0 flex-1">
              <h4 class="text-base sm:text-lg font-bold text-slate-800">Forward to your mobile</h4>
              <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                <p class="text-xs sm:text-sm text-slate-600">Ring for 20 seconds</p>
                <span class="text-xs px-2 sm:px-3 py-1 bg-blue-100 text-blue-600 rounded-full font-medium self-start sm:self-auto">Optional</span>
              </div>
            </div>
          </div>

          <!-- Step 3: Voicemail -->
          <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-6 rounded-xl transition-all duration-300"
               :class="currentStep >= 3 ? 'bg-purple-50 border-2 border-purple-200 shadow-md' : 'bg-gray-50 border-2 border-gray-200'">
            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full flex items-center justify-center transition-colors duration-300 flex-shrink-0"
                 :class="currentStep >= 3 ? 'bg-purple-500 text-white shadow-lg' : 'bg-gray-300 text-gray-600'">
              <font-awesome-icon :icon="['fas', 'fa-voicemail']" class="text-sm sm:text-lg" />
            </div>
            <div class="min-w-0 flex-1">
              <h4 class="text-base sm:text-lg font-bold text-slate-800">Custom voicemail plays if unanswered</h4>
              <p class="text-xs sm:text-sm text-slate-600">You can define your custom message</p>
            </div>
          </div>

          <!-- Step 4: Transcription -->
          <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-6 rounded-xl transition-all duration-300"
               :class="currentStep >= 4 ? 'bg-green-50 border-2 border-green-200 shadow-md' : 'bg-gray-50 border-2 border-gray-200'">
            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full flex items-center justify-center transition-colors duration-300 flex-shrink-0"
                 :class="currentStep >= 4 ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-300 text-gray-600'">
              <font-awesome-icon :icon="['fas', 'fa-file-text']" class="text-sm sm:text-lg" />
            </div>
            <div class="min-w-0 flex-1">
              <h4 class="text-base sm:text-lg font-bold text-slate-800">Voicemail transcribed instantly</h4>
              <p class="text-xs sm:text-sm text-slate-600">AI converts speech to text in seconds</p>
            </div>
          </div>
        </div>

        <!-- Right Side: Live Results -->
        <div class="space-y-6 sm:space-y-8">
          <!-- Summary to You -->
          <div class="bg-gradient-to-br from-white to-sky-50 rounded-xl sm:rounded-2xl border-2 p-4 sm:p-6 lg:p-8 transition-all duration-500 shadow-lg"
               :class="showCallSummary ? 'border-sky-200 shadow-2xl scale-105' : 'border-gray-200 opacity-50'">
            <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
              <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center shadow-md flex-shrink-0">
                <font-awesome-icon :icon="['fas', 'fa-user-tie']" class="text-sky-600 text-lg sm:text-xl" />
              </div>
              <div class="min-w-0 flex-1">
                <h4 class="text-base sm:text-lg lg:text-xl font-bold text-slate-800">Smart SMS sent to you</h4>
                <p class="text-xs sm:text-sm text-slate-600">Your AI agent summarises everything</p>
              </div>
            </div>

            <div class="bg-white rounded-xl p-3 sm:p-4 shadow-sm" v-show="showCallSummary">
              <div class="flex justify-end">
                <div class="bg-blue-500 rounded-2xl rounded-br-md px-3 sm:px-4 py-2 sm:py-3 max-w-[90%] sm:max-w-sm">
                  <p class="text-xs sm:text-sm text-white leading-relaxed">
                    📞 Missed Call from 0482 123 456<br>
                    💬 Fuse box tripping — wants someone this week<br>
                    💰 Est. Value: $320–$450<br>
                    ⚡ Urgency: Medium
                  </p>
                  <div class="text-xs text-blue-200 mt-2 flex items-center justify-end">
                    <span>10:18 AM</span>
                    <div class="ml-1 text-white">✓✓</div>
                  </div>
                </div>
              </div>
              <div class="flex justify-center mt-3 sm:mt-4">
                <span class="bg-green-100 text-green-800 px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-bold">
                  🧠 Summary sent in 15 seconds
                </span>
              </div>
            </div>
          </div>

          <!-- Auto-Reply to Customer -->
          <div class="bg-gradient-to-br from-white to-green-50 rounded-xl sm:rounded-2xl border-2 p-4 sm:p-6 lg:p-8 transition-all duration-500 shadow-lg"
               :class="showAutoReply ? 'border-green-200 shadow-2xl scale-105' : 'border-gray-200 opacity-50'">
            <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
              <div class="bg-green-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center shadow-md flex-shrink-0">
                <font-awesome-icon :icon="['fas', 'fa-reply']" class="text-green-600 text-lg sm:text-xl" />
              </div>
              <div class="min-w-0 flex-1">
                <h4 class="text-base sm:text-lg lg:text-xl font-bold text-slate-800">Auto-reply sent to caller</h4>
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                  <p class="text-xs sm:text-sm text-slate-600">Professional quote based on your pricing</p>
                  <span class="text-xs px-2 sm:px-3 py-1 bg-green-100 text-green-600 rounded-full font-medium self-start sm:self-auto">Optional</span>
                </div>
              </div>
            </div>

            <div class="bg-white rounded-xl p-3 sm:p-4 shadow-sm" v-show="showAutoReply">
              <div class="flex justify-end">
                <div class="bg-blue-500 rounded-2xl rounded-br-md px-3 sm:px-4 py-2 sm:py-3 max-w-[90%] sm:max-w-sm">
                  <p class="text-xs sm:text-sm text-white leading-relaxed">Thanks for calling! Fuse box issues typically $320-450 incl. callout. I'll check your message and get back shortly. If urgent, reply here. - Dave</p>
                  <div class="text-xs text-blue-200 mt-2 flex items-center justify-end">
                    <span>10:19 AM</span>
                    <div class="ml-1 text-white">✓✓</div>
                  </div>
                </div>
              </div>
              <div class="flex justify-center mt-3 sm:mt-4">
                <span class="bg-green-100 text-green-800 px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-bold">
                  🤖 Auto-Reply Sent Instantly
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>