<script setup>
import { ref } from 'vue';

const activeTab = ref('sms');

const scenarios = {
  sms: {
    icon: 'comment-dots',
    title: 'Text Message',
    stories: [
      {
        time: '8:30 PM Saturday Night',
        message: '"Need urgent plumber - hot water system broken, family visiting tomorrow"',
        icon: 'clock',
        color: 'bg-blue-500'
      },
      {
        time: 'You\'re Having Dinner',
        message: 'Phone on silent. Family time is sacred. You\'ll check messages later.',
        icon: 'utensils',
        color: 'bg-orange-500'
      },
      {
        time: 'Next Morning: "Job Filled"',
        message: 'Customer already booked someone else. You lost a $500 emergency job.',
        icon: 'times-circle',
        color: 'bg-red-500'
      }
    ]
  },
  call: {
    icon: 'phone-slash',
    title: 'Missed Call',
    stories: [
      {
        time: '2:15 PM Weekday',
        message: 'Customer calls about urgent electrical issue. You\'re on another job site.',
        icon: 'phone-alt',
        color: 'bg-blue-500'
      },
      {
        time: 'Generic Voicemail Plays',
        message: '"Hi, you\'ve reached... please leave a message." Sounds unprofessional.',
        icon: 'voicemail',
        color: 'bg-orange-500'
      },
      {
        time: 'They Call Next Tradie',
        message: 'Someone else answers immediately and wins the $500 job.',
        icon: 'user-times',
        color: 'bg-red-500'
      }
    ]
  }
};
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="text-center mb-8 sm:mb-12">
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-4 sm:mb-6">
        The $500 Communication Problem
      </h2>
      <p class="text-base sm:text-lg lg:text-xl text-blue-100 max-w-4xl mx-auto mb-6 sm:mb-8">
        Every delayed response costs you real money. Whether they text or call, slow communication = lost jobs.
      </p>
      
      <!-- Tab Switcher -->
      <div class="inline-flex bg-white/15 backdrop-blur-sm rounded-2xl p-1.5 sm:p-2 gap-1 sm:gap-2">
        <button
          @click="activeTab = 'sms'"
          :class="[
            'px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold transition-all duration-300 flex items-center cursor-pointer text-sm sm:text-base',
            activeTab === 'sms' 
              ? 'bg-white text-blue-600 shadow-lg' 
              : 'text-white hover:bg-white/20'
          ]"
        >
          <font-awesome-icon :icon="['fas', 'comment-dots']" class="mr-1 sm:mr-2 text-sm sm:text-base" />
          SMS Scenario
        </button>
        <button
          @click="activeTab = 'call'"
          :class="[
            'px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold transition-all duration-300 flex items-center cursor-pointer text-sm sm:text-base',
            activeTab === 'call' 
              ? 'bg-white text-blue-600 shadow-lg' 
              : 'text-white hover:bg-white/20'
          ]"
        >
          <font-awesome-icon :icon="['fas', 'phone-slash']" class="mr-1 sm:mr-2 text-sm sm:text-base" />
          Call Scenario
        </button>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12">
      <!-- Left Side: Story -->
      <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-xl">
        <div class="text-center mb-6 sm:mb-8">
          <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500 to-sky-600 rounded-2xl mb-3 sm:mb-4 shadow-lg">
            <font-awesome-icon 
              :icon="['fas', scenarios[activeTab].icon]" 
              class="text-lg sm:text-2xl text-white" 
            />
          </div>
          <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">
            {{ scenarios[activeTab].title }} Scenario
          </h3>
          <p class="text-sm sm:text-base text-gray-600">Here's how you lose a $500 job</p>
        </div>

        <div class="space-y-6 sm:space-y-8">
          <div 
            v-for="(story, index) in scenarios[activeTab].stories" 
            :key="index"
            class="group relative rounded-2xl p-4 sm:p-6 transition-all duration-300 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50/30 hover:shadow-xl hover:scale-[1.02] cursor-pointer border border-transparent hover:border-blue-100"
          >
            <div class="flex items-start gap-4 sm:gap-6">
              <div 
                :class="[
                  'rounded-xl w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-md flex-shrink-0 transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl group-hover:-translate-y-1',
                  story.color
                ]"
              >
                <font-awesome-icon :icon="['fas', story.icon]" class="text-white text-sm sm:text-base" />
              </div>
              <div class="min-w-0 flex-1 pt-1">
                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-gray-800 transition-colors duration-300">{{ story.time }}</h4>
                <p class="text-sm sm:text-base text-gray-700 leading-relaxed group-hover:text-gray-600 transition-colors duration-300">{{ story.message }}</p>
              </div>
            </div>
            <!-- Subtle hover indicator -->
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-blue-500/5 to-sky-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
          </div>
        </div>
      </div>

      <!-- Right Side: Impact Stats -->
      <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-xl">
        <div class="text-center mb-6 sm:mb-8">
          <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl mb-3 sm:mb-4 shadow-lg">
            <font-awesome-icon :icon="['fas', 'chart-line']" class="text-white text-lg sm:text-2xl" />
          </div>
          <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">This Happens Every Week</h3>
          <p class="text-sm sm:text-base text-gray-600">The real cost of slow responses</p>
        </div>
        
        <div class="space-y-3 sm:space-y-4">
          <div class="flex justify-between items-center p-3 sm:p-4 bg-blue-50 rounded-xl border-l-4 border-blue-400 hover:shadow-md transition-all duration-300 hover:bg-blue-100">
            <span class="font-medium text-gray-700 text-sm sm:text-base">Lost weekend jobs</span>
            <span class="font-bold text-base sm:text-lg text-blue-600">2-3 per month</span>
          </div>
          
          <div class="flex justify-between items-center p-3 sm:p-4 bg-orange-50 rounded-xl border-l-4 border-orange-400 hover:shadow-md transition-all duration-300 hover:bg-orange-100">
            <span class="font-medium text-gray-700 text-sm sm:text-base">Lost calls per week</span>
            <span class="font-bold text-base sm:text-lg text-orange-600">4-6 calls</span>
          </div>
          
          <div class="flex justify-between items-center p-3 sm:p-4 bg-gray-50 rounded-xl border-l-4 border-gray-300 hover:shadow-md transition-all duration-300 hover:bg-gray-100">
            <span class="font-medium text-gray-700 text-sm sm:text-base">Average job value</span>
            <span class="font-bold text-base sm:text-lg text-gray-900">$400-800</span>
          </div>
          
          <div class="flex justify-between items-center p-3 sm:p-4 bg-red-50 rounded-xl border-l-4 border-red-400 hover:shadow-md transition-all duration-300 hover:bg-red-100">
            <span class="font-medium text-gray-700 text-sm sm:text-base">Monthly lost revenue</span>
            <span class="font-bold text-base sm:text-lg text-red-600">$2,400-4,800</span>
          </div>
        </div>

        <!-- Bottom Call-out -->
        <div class="mt-6 sm:mt-8 p-4 sm:p-6 bg-gradient-to-r from-red-500 to-pink-600 rounded-2xl text-center text-white hover:shadow-xl transition-shadow duration-300">
          <div class="text-xl sm:text-2xl font-black mb-2">$28,000+ Per Year</div>
          <div class="text-red-100 font-medium text-sm sm:text-base">In lost revenue from slow responses</div>
        </div>
      </div>
    </div>

    <!-- Bottom Section -->
    <div class="mt-12 sm:mt-16 text-center">
      <div class="bg-gradient-to-r from-green-500/20 to-blue-500/20 backdrop-blur-sm rounded-2xl sm:rounded-3xl p-6 sm:p-8 lg:p-10 max-w-5xl mx-auto border border-white/30 shadow-2xl">
        <div class="flex items-center justify-center gap-2 sm:gap-4 mb-6">
          <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl shadow-lg">
            <font-awesome-icon :icon="['fas', 'envelope']" class="text-white text-lg sm:text-2xl lg:text-3xl" />
          </div>
          <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl shadow-lg">
            <font-awesome-icon :icon="['fas', 'robot']" class="text-white text-lg sm:text-2xl lg:text-3xl" />
          </div>
          <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl shadow-lg">
            <font-awesome-icon :icon="['fas', 'phone-alt']" class="text-white text-lg sm:text-2xl lg:text-3xl" />
          </div>
        </div>
        
        <h4 class="text-2xl sm:text-3xl font-bold text-white mb-4 sm:mb-6">
          PingMate Solves Both Problems Instantly
        </h4>
        <p class="text-base sm:text-lg lg:text-xl text-green-100 leading-relaxed max-w-3xl mx-auto">
          Whether customers text or call, PingMate responds professionally in seconds. Never lose another $500 job to slow communication again.
        </p>
      </div>
    </div>
  </div>
</template>