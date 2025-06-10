<script setup></script>

<template>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-8 sm:mb-12">
        <h2 class="text-3xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
        Beat Competitors with Lightning-Fast SMS Replies
        </h2>
        <p class="text-lg sm:text-xl text-slate-600 max-w-3xl mx-auto">
        Customer texts you at 8:30 PM? AI replies instantly with a professional quote using your rates. Weekend inquiry? No worries, you're always first to respond.
        </p>
    </div>
    
    <!-- SMS Examples Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16">
        <!-- Electrician SMS -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-sky-100 hover:scale-105 transition-transform duration-300">
        <div class="text-center mb-4 sm:mb-6">
            <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
            <font-awesome-icon :icon="['fas', 'bolt']" class="text-sky-600 text-lg sm:text-2xl" />
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-xs sm:text-sm text-slate-600">Electrician Example</p>
        </div>
        
        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-xs">
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
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-xs">
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
            <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-sky-600 text-lg sm:text-2xl" />
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-xs sm:text-sm text-slate-600">Plumber Example</p>
        </div>
        
        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-xs">
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
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-xs">
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
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-sky-100 hover:scale-105 transition-transform duration-300">
        <div class="text-center mb-4 sm:mb-6">
            <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
            <font-awesome-icon :icon="['fas', 'fa-wand-sparkles']" class="text-sky-600 text-lg sm:text-2xl" />
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-xs sm:text-sm text-slate-600">Cleaner Example</p>
        </div>
        
        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 space-y-2 sm:space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-xs">
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
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-2 sm:px-3 py-1.5 sm:py-2 max-w-xs">
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
    </div>

    <!-- Lead Generation Flow Chart -->
    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 shadow-lg border border-sky-100">
        <div class="text-center mb-6 sm:mb-8">
        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">Never Lose Work to Slow Responses Again</h3>
        <p class="text-slate-600 text-sm sm:text-base">Two ways customers can reach you - both get instant professional replies</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Website Forms Flow -->
        <div class="space-y-4 sm:space-y-6">
            <div class="text-center">
            <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
                <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-sky-600 text-lg sm:text-2xl" />
            </div>
            <h4 class="text-lg sm:text-xl font-bold text-slate-900">Website Forms</h4>
            </div>
            
            <div class="space-y-3 sm:space-y-4">
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0">1</div>
                <div class="min-w-0">
                <p class="font-semibold text-slate-900 text-sm sm:text-base">Embed Form on Website</p>
                <p class="text-xs sm:text-sm text-slate-600">Add quote form to your site with one line of code</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0">2</div>
                <div class="min-w-0">
                <p class="font-semibold text-slate-900 text-sm sm:text-base">Customer Submits Request</p>
                <p class="text-xs sm:text-sm text-slate-600">Form captures project details and contact info</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0">3</div>
                <div class="min-w-0">
                <p class="font-semibold text-slate-900 text-sm sm:text-base">AI Creates Professional Quote</p>
                <p class="text-xs sm:text-sm text-slate-600">Using your pricing and business style</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="bg-green-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0">4</div>
                <div class="min-w-0">
                <p class="font-semibold text-slate-900 text-sm sm:text-base">Instant Email + SMS Response</p>
                <p class="text-xs sm:text-sm text-slate-600">Customer gets quote in under 30 seconds</p>
                </div>
            </div>
            </div>
        </div>

        <!-- SMS Flow -->
        <div class="space-y-4 sm:space-y-6">
            <div class="text-center">
            <div class="bg-sky-100 rounded-full w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-2 sm:mb-3">
                <font-awesome-icon :icon="['fas', 'fa-mobile-alt']" class="text-sky-600 text-lg sm:text-2xl" />
            </div>
            <h4 class="text-lg sm:text-xl font-bold text-slate-900">SMS Responses</h4>
            </div>
            
            <div class="space-y-3 sm:space-y-4">
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0">1</div>
                <div class="min-w-0">
                <p class="font-semibold text-slate-900 text-sm sm:text-base">Get Australian Phone Number</p>
                <p class="text-xs sm:text-sm text-slate-600">Your dedicated business line for all trades</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0">2</div>
                <div class="min-w-0">
                <p class="font-semibold text-slate-900 text-sm sm:text-base">Customer Texts Project Details</p>
                <p class="text-xs sm:text-sm text-slate-600">Any time, day or night - even weekends</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0">3</div>
                <div class="min-w-0">
                <p class="font-semibold text-slate-900 text-sm sm:text-base">AI Replies Instantly</p>
                <p class="text-xs sm:text-sm text-slate-600">Professional quote with your voice and pricing</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="bg-green-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0">4</div>
                <div class="min-w-0">
                <p class="font-semibold text-slate-900 text-sm sm:text-base">Book More Jobs</p>
                <p class="text-xs sm:text-sm text-slate-600">First to respond usually gets the work</p>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
</template>