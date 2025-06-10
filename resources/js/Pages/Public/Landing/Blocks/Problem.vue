<script setup></script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 sm:mb-16 lg:mb-20">
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 sm:mb-6">
        The $500 Text Message Problem
      </h2>
      <p class="text-lg sm:text-xl lg:text-2xl text-red-100 max-w-3xl mx-auto">
        Every delayed SMS reply costs you real money. Here's how it happens...
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">
      <!-- Left Story Column -->
      <div class="space-y-6 sm:space-y-8">
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-xl hover:scale-105 transition-transform duration-300">
          <div class="flex items-start">
            <div class="bg-yellow-400 text-white rounded-lg sm:rounded-xl w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-300 p-3 sm:p-4 mr-4 sm:mr-6 mt-1 flex-shrink-0">
              <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-lg sm:text-2xl" />
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">8:30 PM Saturday Night</h3>
              <p class="text-gray-900 text-sm sm:text-base lg:text-lg leading-relaxed">
                "Need urgent plumber - hot water system broken, family visiting tomorrow"
              </p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-xl hover:scale-105 transition-transform duration-300">
          <div class="flex items-start">
            <div class="bg-red-600 text-white rounded-lg sm:rounded-xl w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-300 p-3 sm:p-4 mr-4 sm:mr-6 mt-1 flex-shrink-0">
              <font-awesome-icon :icon="['fas', 'fa-times']" class="text-lg sm:text-2xl" />
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">You're Having Dinner</h3>
              <p class="text-gray-900 text-sm sm:text-base lg:text-lg leading-relaxed">
                Phone on silent. Family time is sacred. You'll check messages later.
              </p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-xl hover:scale-105 transition-transform duration-300">
          <div class="flex items-start">
            <div class="bg-gray-700 text-white rounded-lg sm:rounded-xl w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-300 p-3 sm:p-4 mr-4 sm:mr-6 mt-1 flex-shrink-0">
              <font-awesome-icon :icon="['fas', 'fa-sad-tear']" class="text-lg sm:text-2xl" />
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">Next Morning: "Job Filled"</h3>
              <p class="text-gray-900 text-sm sm:text-base lg:text-lg leading-relaxed">
                Customer already booked someone else. You lost a $500 emergency job.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Stats Column -->
      <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-8 lg:p-10 border border-gray-200 self-start mt-8 lg:mt-0">
        <h3 class="text-2xl sm:text-2xl lg:text-3xl font-black text-gray-900 mb-6 sm:mb-8 text-center">This Happens Every Week</h3>
        <div class="space-y-4 sm:space-y-6">
          <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-200">
            <span class="text-gray-700 text-sm sm:text-base lg:text-lg font-medium">Lost weekend jobs</span>
            <span class="font-bold text-lg sm:text-xl text-red-600">2-3 per month</span>
          </div>
          <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-200">
            <span class="text-gray-700 text-sm sm:text-base lg:text-lg font-medium">Average job value</span>
            <span class="font-bold text-lg sm:text-xl text-gray-900">$400-800</span>
          </div>
          <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-200">
            <span class="text-gray-700 text-sm sm:text-base lg:text-lg font-medium">Monthly lost revenue</span>
            <span class="font-bold text-xl sm:text-2xl text-red-600">$1,200-2,400</span>
          </div>
          <div class="bg-red-100 rounded-xl sm:rounded-2xl p-4 sm:p-6 mt-4 sm:mt-6 shadow">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
              <span class="font-bold text-base sm:text-lg lg:text-xl text-gray-900">Potential lost revenue per year</span>
              <span class="font-black text-xl sm:text-2xl text-red-600">$15,000 - $30,000</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
