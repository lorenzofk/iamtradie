<script setup>

</script>

<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">
        I am Tradie: Your AI That Never Sleeps
        </h2>
        <p class="text-xl text-gray-600">
        Capture every lead with instant, professional responses using I am Tradie
        </p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start relative">
        <!-- Vertical Separator - Hidden on mobile, visible on desktop -->
        <div class="hidden lg:block absolute left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-transparent via-gray-200 to-transparent transform -translate-x-1/2"></div>
        
        <!-- Left Side - Scenario Timeline -->
        <div class="relative lg:pr-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6">
            <h3 class="text-2xl font-bold text-white flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-robot']" class="mr-3" />
                Same Scenario With I am Tradie
            </h3>
            </div>
            
            <div class="p-8">
            <!-- Timeline -->
            <div class="relative">
                <!-- Vertical line -->
                <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gradient-to-b from-blue-200 via-green-200 to-green-400"></div>
                
                <div class="space-y-8">
                <!-- Step 1 -->
                <div class="relative flex items-start">
                    <div class="bg-blue-500 rounded-full p-3 shadow-lg z-10 border-4 border-white">
                    <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-white text-sm" />
                    </div>
                    <div class="ml-8 bg-blue-50 rounded-lg p-4 flex-1 border-l-4 border-blue-400">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-blue-900">Customer texts</h4>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">8:30 PM</span>
                    </div>
                    <p class="text-blue-700 text-sm">Same urgent hot water problem</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="relative flex items-start">
                    <div class="bg-yellow-500 rounded-full p-3 shadow-lg z-10 border-4 border-white">
                    <font-awesome-icon :icon="['fas', 'fa-bolt']" class="text-white text-sm" />
                    </div>
                    <div class="ml-8 bg-yellow-50 rounded-lg p-4 flex-1 border-l-4 border-yellow-400">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-yellow-900">AI responds instantly</h4>
                        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">8:30:03 PM</span>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-yellow-200 shadow-sm">
                        <p class="text-gray-700 text-sm italic">"G'day! Hot water repairs typically $420-680 incl. callout. Emergency available tonight. Can I book you in? Cheers, Dave."</p>
                    </div>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="relative flex items-start">
                    <div class="bg-green-500 rounded-full p-3 shadow-lg z-10 border-4 border-white">
                    <font-awesome-icon :icon="['fas', 'fa-check']" class="text-white text-sm" />
                    </div>
                    <div class="ml-8 bg-green-50 rounded-lg p-4 flex-1 border-l-4 border-green-400">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-green-900">Job booked</h4>
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">8:35 PM</span>
                    </div>
                    <p class="text-green-700 text-sm">Customer replies to book. You check phone after dinner, confirm time.</p>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Result Banner -->
            <div class="mt-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-6 text-center shadow-lg">
                <div class="flex items-center justify-center mb-2">
                <font-awesome-icon :icon="['fas', 'fa-trophy']" class="text-yellow-300 text-2xl mr-3" />
                <div class="text-3xl font-bold text-white">$500+ Job Secured</div>
                </div>
                <div class="text-green-100 text-lg">While you enjoyed dinner</div>
            </div>
            </div>
        </div>
        </div>
        
        <!-- Right Side - How It Works -->
        <div class="lg:pl-8">
        <div class="mb-10">
            <h3 class="text-3xl font-bold text-gray-900 mb-4">
            <font-awesome-icon :icon="['fas', 'fa-wand-sparkles']" class="mr-3 text-blue-600" />
            How I am Tradie AI Works
            </h3>
            <p class="text-gray-600 text-lg">Simple setup, powerful results</p>
        </div>
        
        <div class="space-y-6">
            <!-- Step 1 -->
            <div class="group bg-white border border-gray-200 rounded-xl p-6 shadow-xl hover:scale-110 transition-transform duration-300">
            <div class="flex items-start">
                <div class="relative flex-shrink-0">
                <div class="bg-gradient-to-br from-orange-400 to-red-500 rounded-xl w-14 h-14 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="font-bold text-white text-lg">1</span>
                </div>
                <div class="absolute -top-1 -right-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                    <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-white text-xs" />
                </div>
                </div>
                <div class="ml-6 flex-1">
                <h4 class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                    Your Australian Business Number
                </h4>
                <p class="text-gray-600 leading-relaxed mb-3">
                    We give you a local Aussie number. Customers text you directly - no app downloads or complicated setup.
                </p>
                <div class="flex items-center text-sm text-blue-600">
                    <font-awesome-icon :icon="['fas', 'fa-check-circle']" class="mr-2" />
                    Instant setup
                </div>
                </div>
            </div>
            </div>
            
            <!-- Step 2 -->
            <div class="group bg-white border border-gray-200 rounded-xl p-6 shadow-xl hover:scale-110 transition-transform duration-300">
            <div class="flex items-start">
                <div class="relative flex-shrink-0">
                <div class="bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl w-14 h-14 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="font-bold text-white text-lg">2</span>
                </div>
                <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                    <font-awesome-icon :icon="['fas', 'fa-brain']" class="text-white text-xs" />
                </div>
                </div>
                <div class="ml-6 flex-1">
                <h4 class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                    AI Reads & Understands
                </h4>
                <p class="text-gray-600 leading-relaxed mb-3">
                    Smart AI instantly understands what job they need and calculates quotes using YOUR actual callout fees and hourly rates.
                </p>
                <div class="flex items-center text-sm text-green-600">
                    <font-awesome-icon :icon="['fas', 'fa-bolt-lightning']" class="mr-2" />
                    Instant analysis
                </div>
                </div>
            </div>
            </div>
            
            <!-- Step 3 -->
            <div class="group bg-white border border-gray-200 rounded-xl p-6 shadow-xl hover:scale-110 transition-transform duration-300">
            <div class="flex items-start">
                <div class="relative flex-shrink-0">
                <div class="bg-gradient-to-br from-green-400 to-teal-500 rounded-xl w-14 h-14 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="font-bold text-white text-lg">3</span>
                </div>
                <div class="absolute -top-1 -right-1 w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                    <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-white text-xs" />
                </div>
                </div>
                <div class="ml-6 flex-1">
                <h4 class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                    Professional Reply in Seconds
                </h4>
                <p class="text-gray-600 leading-relaxed mb-3">
                    AI replies using your business voice - casual, professional, or polite. Customers think you responded personally.
                </p>
                <div class="flex items-center text-sm text-purple-600">
                    <font-awesome-icon :icon="['fas', 'fa-stopwatch']" class="mr-2" />
                    Under 3 seconds
                </div>
                </div>
            </div>
            </div>
            
            <!-- Step 4 -->
            <div class="group bg-white border border-gray-200 rounded-xl p-6 shadow-xl hover:scale-110 transition-transform duration-300">
            <div class="flex items-start">
                <div class="relative flex-shrink-0">
                <div class="bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl w-14 h-14 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="font-bold text-white text-lg">4</span>
                </div>
                <div class="absolute -top-1 -right-1 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                    <font-awesome-icon :icon="['fas', 'fa-trophy']" class="text-white text-xs" />
                </div>
                </div>
                <div class="ml-6 flex-1">
                <h4 class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                    You Win More Work
                </h4>
                <p class="text-gray-600 leading-relaxed mb-3">
                    Be first to respond, every time. Win jobs while competitors are asleep, at dinner, or busy on other sites.
                </p>
                <div class="flex items-center text-sm text-yellow-600">
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