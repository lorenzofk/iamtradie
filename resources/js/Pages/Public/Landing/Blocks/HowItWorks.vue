<script setup>
import { router } from '@inertiajs/vue3';
import Button from '@/Shared/Ui/Button/Button.vue';

const visit = (url) => {
  router.visit(url);
};

const callWorkflowSteps = [
  {
    id: 1,
    title: "Customer calls your business number",
    subtitle: "Looks local with your own Aussie number",
    color: "sky",
    status: "primary"
  },
  {
    id: 2,
    title: "Forward to your mobile",
    subtitle: null,
    color: "blue",
    status: "optional",
    badge: "Optional"
  },
  {
    id: 3,
    title: "Custom voicemail plays if unanswered",
    subtitle: "You can define your custom message",
    color: "blue",
    status: "secondary"
  },
  {
    id: 4,
    title: "Voicemail transcribed instantly",
    subtitle: null,
    color: "blue",
    status: "secondary"
  },
  {
    id: 5,
    title: "Smart SMS sent to you",
    subtitle: "Your AI agent summarises what they said, what they want, and potential price",
    color: "blue",
    status: "secondary"
  },
  {
    id: 6,
    title: "Auto-reply sent to caller",
    subtitle: "Your AI agent summarises what they said and send them an instant quote based on your pricing",
    color: "green",
    status: "success",
    badge: "Optional"
  }
];

const smsWorkflowSteps = [
  {
    id: 1,
    title: "Customer texts your number",
    subtitle: "24/7 — even weekends or after hours",
    color: "sky",
    status: "primary"
  },
  {
    id: 2,
    title: "AI reads the message and understands intent and the customer's needs",
    subtitle: null,
    color: "blue",
    status: "secondary"
  },
  {
    id: 3,
    title: "Instant quote based on your pricing and the job description",
    subtitle: null,
    color: "blue",
    status: "secondary"
  },
  {
    id: 4,
    title: "You're first to respond",
    subtitle: "Which often means you win the job!",
    color: "green",
    status: "success"
  }
];

const getStepClasses = (color, status) => {
  const colorMap = {
    sky: status === 'primary' ? 'bg-sky-500' : 'bg-sky-400',
    blue: 'bg-blue-400',
    green: 'bg-green-500'
  };
  return colorMap[color] || 'bg-gray-400';
};

const getBadgeClasses = (status) => {
  if (status === 'optional') return 'text-blue-600 bg-blue-100';
  if (status === 'success') return 'text-green-600 bg-green-100';
  return 'text-gray-600 bg-gray-100';
};
</script>

<template>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-8 sm:mb-12">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
        Beat Competitors with Lightning-Fast SMS Replies
        </h2>
        <p class="text-base sm:text-lg lg:text-xl text-slate-600 max-w-3xl mx-auto">
        Customer texts you at 8:30 PM? AI replies instantly with a professional quote using your rates. Weekend inquiry? No worries, you're always first to respond.
        </p>
    </div>
    
    <!-- SMS Examples Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 mb-12 sm:mb-16">
        <!-- Electrician SMS -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-sky-100 hover:scale-105 transition-transform duration-300">
        <div class="text-center mb-4 sm:mb-6">
            <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
            <font-awesome-icon :icon="['fas', 'bolt']" class="text-sky-600 text-base sm:text-lg lg:text-2xl" />
            </div>
            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-xs sm:text-sm text-slate-600">Electrician Example</p>
        </div>
        
        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
                <p class="text-xs sm:text-sm text-gray-800">Need power points installed in new kitchen</p>
                <div class="text-xs text-gray-500 mt-1">2:15 PM</div>
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
            
            <div class="flex justify-end">
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
                <p class="text-xs sm:text-sm text-white">G'day! Power point install typically $380-$520 incl. callout. Takes 2-3 hours. Happy to give you a proper quote! Cheers, Dave.</p>
                <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                <span>2:15 PM</span>
                <div class="ml-1 text-white">✓✓</div>
                </div>
            </div>
            </div>
            
            <div class="flex justify-center">
            <span class="bg-green-100 text-green-800 px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
                ⚡ Replied in 2 seconds
            </span>
            </div>
        </div>
        </div>

        <!-- Plumber SMS -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-sky-100 hover:scale-105 transition-transform duration-300">
        <div class="text-center mb-4 sm:mb-6">
            <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
            <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-sky-600 text-base sm:text-lg lg:text-2xl" />
            </div>
            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-xs sm:text-sm text-slate-600">Plumber Example</p>
        </div>
        
        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
                <p class="text-xs sm:text-sm text-gray-800">Hot water system leaking, need urgent repair</p>
                <div class="text-xs text-gray-500 mt-1">9:22 PM</div>
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
            
            <div class="flex justify-end">
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
                <p class="text-xs sm:text-sm text-white">No worries mate! Hot water repairs $420-$680 incl. callout. Can come out tonight if urgent. Give us a bell! - Mike</p>
                <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                <span>9:22 PM</span>
                <div class="ml-1 text-white">✓✓</div>
                </div>
            </div>
            </div>
            
            <div class="flex justify-center">
            <span class="bg-green-100 text-green-800 px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
                ⚡ Replied in 3 seconds
            </span>
            </div>
        </div>
        </div>

        <!-- Cleaner SMS -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-sky-100 hover:scale-105 transition-transform duration-300 md:col-span-2 lg:col-span-1">
        <div class="text-center mb-4 sm:mb-6">
            <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
            <font-awesome-icon :icon="['fas', 'fa-wand-sparkles']" class="text-sky-600 text-base sm:text-lg lg:text-2xl" />
            </div>
            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-xs sm:text-sm text-slate-600">Cleaner Example</p>
        </div>
        
        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
                <p class="text-xs sm:text-sm text-gray-800">Bond clean for 3 bedroom house next week?</p>
                <div class="text-xs text-gray-500 mt-1">4:45 PM</div>
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
            
            <div class="flex justify-end">
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
                <p class="text-xs sm:text-sm text-white">Hi there! 3BR bond clean typically $680-$950. Includes all rooms, kitchen, bathrooms. Guaranteed to pass inspection! - Sarah</p>
                <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                <span>4:45 PM</span>
                <div class="ml-1 text-white">✓✓</div>
                </div>
            </div>
            </div>
            
            <div class="flex justify-center">
            <span class="bg-green-100 text-green-800 px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
                ⚡ Replied in 4 seconds
            </span>
            </div>
        </div>
        </div>

        <!-- Missed Call AI Summary Card (Styled Like SMS) - SMS to You -->
<div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-sky-100 hover:scale-105 transition-transform duration-300 md:col-span-2 lg:col-span-1">
  <div class="text-center mb-4 sm:mb-6">
    <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
      <font-awesome-icon :icon="['fas', 'fa-phone-slash']" class="text-sky-600 text-base sm:text-lg lg:text-2xl" />
    </div>
    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-900">Call Summary</h3>
    <p class="text-xs sm:text-sm text-slate-600">Electrician Example</p>
  </div>

  <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
    <div class="flex justify-start">
      <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
        <p class="text-xs sm:text-sm text-gray-800">Hey mate, just need someone to take a look at a fuse box tripping out. Can you swing by this week?</p>
        <div class="text-xs text-gray-500 mt-1">10:18 AM</div>
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

    <div class="flex justify-end">
      <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
        <p class="text-xs sm:text-sm text-white">
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

    <div class="flex justify-center">
      <span class="bg-green-100 text-green-800 px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
        🧠 Summary sent in 15 seconds
      </span>
    </div>
  </div>
</div>

<!-- Auto Reply to Customer Example (Styled Like SMS) -->
<div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-sky-100 hover:scale-105 transition-transform duration-300 md:col-span-2 lg:col-span-1">
  <div class="text-center mb-4 sm:mb-6">
    <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
      <font-awesome-icon :icon="['fas', 'fa-reply']" class="text-sky-600 text-base sm:text-lg lg:text-2xl" />
    </div>
    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-slate-900">Auto-Reply to Caller</h3>
    <p class="text-xs sm:text-sm text-slate-600">What Your Customer Receives</p>
  </div>

  <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
    <div class="flex justify-start">
      <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
        <p class="text-xs sm:text-sm text-gray-800">Hey mate, just need someone to take a look at a fuse box tripping out. Can you swing by this week?</p>
        <div class="text-xs text-gray-500 mt-1">10:18 AM</div>
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

    <div class="flex justify-end">
      <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-[85%] sm:max-w-xs">
        <p class="text-xs sm:text-sm text-white">
          Thanks for calling! I didn’t catch you just now but I’ll check your message and get back shortly. If urgent, reply here. - Dave
        </p>
        <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
          <span>10:19 AM</span>
          <div class="ml-1 text-white">✓✓</div>
        </div>
      </div>
    </div>

    <div class="flex justify-center">
      <span class="bg-green-100 text-green-800 px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
        🤖 Auto-Reply Sent Instantly
      </span>
    </div>
  </div>
</div>

    </div>

    <!-- Modern Split Workflow: Calls & SMS -->
    <div class="bg-gradient-to-br from-slate-50 via-blue-50 to-sky-50">
        <!-- Modern Split Workflow: Calls & SMS -->
        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-xl border border-sky-100 backdrop-blur-sm">
            <div class="text-center mb-8 sm:mb-12">
            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-4 leading-tight">
                Whether They Text or Call — You're Always Covered
            </h3>
            <p class="text-slate-600 text-base sm:text-lg lg:text-xl max-w-4xl mx-auto leading-relaxed">
                PingMate handles every missed call or message — automatically, professionally, and fast.
            </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-10">
            <!-- Call Workflow -->
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-xl p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6 shadow-lg border border-sky-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                <div class="bg-gradient-to-br from-sky-100 to-blue-100 p-3 sm:p-4 rounded-2xl shadow-sm">
                    <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-sky-600 text-lg sm:text-2xl" />
                </div>
                <div>
                    <h4 class="text-xl sm:text-2xl font-bold text-slate-800">Missed Call Handling</h4>
                    <p class="text-slate-600 text-xs sm:text-sm">Never miss another opportunity</p>
                </div>
                </div>

                <div class="space-y-4 sm:space-y-5">
                <div 
                    v-for="step in callWorkflowSteps" 
                    :key="step.id"
                    class="group relative pl-6 sm:pl-8 hover:pl-8 sm:hover:pl-10 transition-all duration-200"
                >
                    <div class="absolute left-0 top-2">
                    <div :class="[
                        'w-3 h-3 sm:w-4 sm:h-4 rounded-full shadow-sm',
                        getStepClasses(step.color, step.status)
                    ]"></div>
                    </div>
                    <div class="pb-1">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 mb-1">
                        <span class="text-sm sm:text-sm font-semibold text-slate-800 leading-relaxed">
                        {{ step.title }}
                        </span>
                        <span 
                        v-if="step.badge"
                        :class="[
                            'text-xs px-2 py-1 rounded-full font-medium self-start sm:self-auto',
                            getBadgeClasses(step.status)
                        ]"
                        >
                        {{ step.badge }}
                        </span>
                    </div>
                    <p 
                        v-if="step.subtitle" 
                        class="text-xs text-slate-500 leading-relaxed pr-2"
                    >
                        {{ step.subtitle }}
                    </p>
                    </div>
                </div>
                </div>
            </div>

            <!-- SMS Workflow -->
            <div class="bg-gradient-to-br from-slate-50 to-sky-50 rounded-xl p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6 shadow-lg border border-sky-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                <div class="bg-gradient-to-br from-sky-100 to-blue-100 p-3 sm:p-4 rounded-2xl shadow-sm">
                    <font-awesome-icon :icon="['fas', 'fa-comment-dots']" class="text-sky-600 text-lg sm:text-2xl" />
                </div>
                <div>
                    <h4 class="text-xl sm:text-2xl font-bold text-slate-800">SMS Replies</h4>
                    <p class="text-slate-600 text-xs sm:text-sm">Instant professional responses</p>
                </div>
                </div>

                <div class="space-y-4 sm:space-y-5">
                <div 
                    v-for="step in smsWorkflowSteps" 
                    :key="step.id"
                    class="group relative pl-6 sm:pl-8 hover:pl-8 sm:hover:pl-10 transition-all duration-200"
                >
                    <div class="absolute left-0 top-2">
                    <div :class="[
                        'w-3 h-3 sm:w-4 sm:h-4 rounded-full shadow-sm',
                        getStepClasses(step.color, step.status)
                    ]"></div>
                    </div>
                    <div class="pb-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm sm:text-sm font-semibold text-slate-800 leading-relaxed">
                        {{ step.title }}
                        </span>
                    </div>
                    <p 
                        v-if="step.subtitle" 
                        class="text-xs text-slate-500 leading-relaxed pr-2"
                    >
                        {{ step.subtitle }}
                    </p>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <!-- Bottom CTA Section -->
            <div class="mt-8 sm:mt-12 text-center">
            <div class="bg-gradient-to-r from-sky-50 to-blue-50 rounded-xl p-4 sm:p-6 border border-sky-100">
                <h5 class="text-base sm:text-lg font-bold text-slate-800 mb-2">
                Ready to Never Miss Another Lead?
                </h5>
                <p class="text-slate-600 text-sm mb-4">
                Join 200+ Australian tradies who capture every opportunity with PingMate
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <Button unstyled @click="visit(route('onboarding.show'))" class="cursor-pointer inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 text-sm sm:text-base">
                        <font-awesome-icon :icon="['fas', 'fa-rocket']" class="mr-2" />
                        Get started now
                    </Button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</template>