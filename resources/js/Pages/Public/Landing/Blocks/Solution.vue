<script setup>

</script>

<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 sm:mb-16">
        <h2 class="text-3xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
        PingMate: Your AI That Never Sleeps
        </h2>
        <p class="text-lg sm:text-xl text-gray-600">
        Capture every lead with instant, professional responses using PingMate
        </p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start relative">
        <!-- Vertical Separator - Hidden on mobile, visible on desktop -->
        <div class="hidden lg:block absolute left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-transparent via-gray-200 to-transparent transform -translate-x-1/2"></div>
        
        <!-- Left Side - Scenario Timeline -->
        <div class="relative lg:pr-8 order-2 lg:order-1">
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-robot']" class="mr-2 sm:mr-3 text-sm sm:text-base" />
                Same Scenario With PingMate
            </h3>
            </div>
            
            <div class="p-4 sm:p-6 lg:p-8">
            <!-- Timeline -->
            <div class="relative">
                <!-- Vertical line -->
                <div class="absolute left-4 sm:left-6 top-0 bottom-0 w-0.5 bg-gradient-to-b from-blue-200 via-green-200 to-green-400"></div>
                
                <div class="space-y-6 sm:space-y-8">
                <!-- Step 1 -->
                <div class="relative flex items-start">
                    <div class="bg-blue-500 rounded-full p-2 sm:p-3 shadow-lg z-10 border-2 sm:border-4 border-white flex-shrink-0">
                    <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-white text-xs sm:text-sm" />
                    </div>
                    <div class="ml-4 sm:ml-8 bg-blue-50 rounded-lg p-3 sm:p-4 flex-1 border-l-2 sm:border-l-4 border-blue-400 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2 space-y-1 sm:space-y-0">
                        <h4 class="font-semibold text-blue-900 text-sm sm:text-base">Customer texts</h4>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full self-start">8:30 PM</span>
                    </div>
                    <p class="text-blue-700 text-xs sm:text-sm">Same urgent hot water problem</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="relative flex items-start">
                    <div class="bg-yellow-500 rounded-full p-2 sm:p-3 shadow-lg z-10 border-2 sm:border-4 border-white flex-shrink-0">
                    <font-awesome-icon :icon="['fas', 'fa-bolt']" class="text-white text-xs sm:text-sm" />
                    </div>
                    <div class="ml-4 sm:ml-8 bg-yellow-50 rounded-lg p-3 sm:p-4 flex-1 border-l-2 sm:border-l-4 border-yellow-400 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2 space-y-1 sm:space-y-0">
                        <h4 class="font-semibold text-yellow-900 text-sm sm:text-base">AI responds instantly</h4>
                        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full self-start">8:30:03 PM</span>
                    </div>
                    <div class="bg-white rounded-lg p-2 sm:p-3 border border-yellow-200 shadow-sm">
                        <p class="text-gray-700 text-xs sm:text-sm italic">"G'day! Hot water repairs typically $420-680 incl. callout. Emergency available tonight. Can I book you in? Cheers, Dave."</p>
                    </div>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="relative flex items-start">
                    <div class="bg-green-500 rounded-full p-2 sm:p-3 shadow-lg z-10 border-2 sm:border-4 border-white flex-shrink-0">
                    <font-awesome-icon :icon="['fas', 'fa-check']" class="text-white text-xs sm:text-sm" />
                    </div>
                    <div class="ml-4 sm:ml-8 bg-green-50 rounded-lg p-3 sm:p-4 flex-1 border-l-2 sm:border-l-4 border-green-400 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2 space-y-1 sm:space-y-0">
                        <h4 class="font-semibold text-green-900 text-sm sm:text-base">Job booked</h4>
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full self-start">8:35 PM</span>
                    </div>
                    <p class="text-green-700 text-xs sm:text-sm">Customer replies to book. You check phone after dinner, confirm time.</p>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Result Banner -->
            <div class="mt-6 sm:mt-8 lg:mt-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-4 sm:p-6 text-center shadow-lg">
                <div class="flex flex-col sm:flex-row items-center justify-center mb-2 space-y-2 sm:space-y-0">
                <font-awesome-icon :icon="['fas', 'fa-trophy']" class="text-yellow-300 text-xl sm:text-2xl sm:mr-3" />
                <div class="text-2xl sm:text-3xl font-bold text-white">$500+ Job Secured</div>
                </div>
                <div class="text-green-100 text-base sm:text-lg">While you enjoyed dinner</div>
            </div>
            </div>
        </div>
        </div>
        
        <!-- Right Side - How It Works -->
        <div class="lg:pl-8 order-1 lg:order-2 mb-8 lg:mb-0">
        <div class="mb-6 sm:mb-8 lg:mb-10">
            <h3 class="text-2xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-3 sm:mb-4">
            <font-awesome-icon :icon="['fas', 'fa-wand-sparkles']" class="mr-2 sm:mr-3 text-blue-600 text-lg sm:text-xl lg:text-2xl" />
            How PingMate AI Works
            </h3>
            <p class="text-gray-600 text-base sm:text-lg">Simple setup, powerful results</p>
        </div>
        
        <div class="space-y-4 sm:space-y-6">
            <!-- Step 1 -->
            <div class="group bg-white border border-gray-200 rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-start">
                <div class="relative flex-shrink-0">
                <div class="bg-gradient-to-br from-orange-400 to-red-500 rounded-lg sm:rounded-xl w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="font-bold text-white text-base sm:text-lg">1</span>
                </div>
                <div class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-blue-500 rounded-full flex items-center justify-center">
                    <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-white text-xs" />
                </div>
                </div>
                <div class="ml-4 sm:ml-6 flex-1 min-w-0">
                <h4 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3 group-hover:text-blue-600 transition-colors">
                    Your Australian Business Number
                </h4>
                <p class="text-gray-600 leading-relaxed mb-2 sm:mb-3 text-sm sm:text-base">
                    We give you a local Aussie number. Customers text you directly - no app downloads or complicated setup.
                </p>
                <div class="flex items-center text-xs sm:text-sm text-blue-600">
                    <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="mr-2" />
                    Instant setup
                </div>
                </div>
            </div>
            </div>
            
            <!-- Step 2 -->
            <div class="group bg-white border border-gray-200 rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-start">
                <div class="relative flex-shrink-0">
                <div class="bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg sm:rounded-xl w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="font-bold text-white text-base sm:text-lg">2</span>
                </div>
                <div class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-green-500 rounded-full flex items-center justify-center">
                    <font-awesome-icon :icon="['fas', 'fa-brain']" class="text-white text-xs" />
                </div>
                </div>
                <div class="ml-4 sm:ml-6 flex-1 min-w-0">
                <h4 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3 group-hover:text-blue-600 transition-colors">
                    AI Reads & Understands
                </h4>
                <p class="text-gray-600 leading-relaxed mb-2 sm:mb-3 text-sm sm:text-base">
                    Smart AI instantly understands what job they need and calculates quotes using YOUR actual callout fees and hourly rates.
                </p>
                <div class="flex items-center text-xs sm:text-sm text-green-600">
                    <font-awesome-icon :icon="['fas', 'fa-bolt-lightning']" class="mr-2" />
                    Instant analysis
                </div>
                </div>
            </div>
            </div>
            
            <!-- Step 3 -->
            <div class="group bg-white border border-gray-200 rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-start">
                <div class="relative flex-shrink-0">
                <div class="bg-gradient-to-br from-green-400 to-teal-500 rounded-lg sm:rounded-xl w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="font-bold text-white text-base sm:text-lg">3</span>
                </div>
                <div class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-purple-500 rounded-full flex items-center justify-center">
                    <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-white text-xs" />
                </div>
                </div>
                <div class="ml-4 sm:ml-6 flex-1 min-w-0">
                <h4 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3 group-hover:text-blue-600 transition-colors">
                    Professional Reply in Seconds
                </h4>
                <p class="text-gray-600 leading-relaxed mb-2 sm:mb-3 text-sm sm:text-base">
                    AI replies using your business voice - casual, professional, or polite. Customers think you responded personally.
                </p>
                <div class="flex items-center text-xs sm:text-sm text-purple-600">
                    <font-awesome-icon :icon="['fas', 'fa-stopwatch']" class="mr-2" />
                    Under 3 seconds
                </div>
                </div>
            </div>
            </div>
            
            <!-- Step 4 -->
            <div class="group bg-white border border-gray-200 rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-xl hover:scale-105 transition-transform duration-300">
            <div class="flex items-start">
                <div class="relative flex-shrink-0">
                <div class="bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg sm:rounded-xl w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="font-bold text-white text-base sm:text-lg">4</span>
                </div>
                <div class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                    <font-awesome-icon :icon="['fas', 'fa-trophy']" class="text-white text-xs" />
                </div>
                </div>
                <div class="ml-4 sm:ml-6 flex-1 min-w-0">
                <h4 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3 group-hover:text-blue-600 transition-colors">
                    You Win More Work
                </h4>
                <p class="text-gray-600 leading-relaxed mb-2 sm:mb-3 text-sm sm:text-base">
                    Be first to respond, every time. Win jobs while competitors are asleep, at dinner, or busy on other sites.
                </p>
                <div class="flex items-center text-xs sm:text-sm text-yellow-600">
                    <font-awesome-icon :icon="['fas', 'fa-chart-line']" class="mr-2" />
                    More jobs won
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</template>