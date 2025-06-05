<script setup></script>

<template>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-slate-900 mb-4">
        Beat Competitors with Lightning-Fast SMS Replies
        </h2>
        <p class="text-xl text-slate-600 max-w-3xl mx-auto">
        Customer texts you at 8:30 PM? AI replies instantly with a professional quote using your rates. Weekend inquiry? No worries, you're always first to respond.
        </p>
    </div>
    
    <!-- SMS Examples Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <!-- Electrician SMS -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-sky-100 hover:scale-110 transition-transform duration-300">
        <div class="text-center mb-6">
            <div class="bg-sky-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
            <font-awesome-icon :icon="['fas', 'bolt']" class="text-sky-600 text-2xl" />
            </div>
            <h3 class="text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-sm text-slate-600">Electrician Example</p>
        </div>
        
        <div class="bg-white rounded-xl p-4 space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-3 py-2 max-w-xs">
                <p class="text-sm text-gray-800">Need power points installed in new kitchen</p>
                <div class="text-xs text-gray-500 mt-1">2:15 PM</div>
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
            
            <div class="flex justify-end">
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-3 py-2 max-w-xs">
                <p class="text-sm text-white">G'day! Power point install typically $380-$520 incl. callout. Takes 2-3 hours. Happy to give you a proper quote! Cheers, Dave.</p>
                <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                <span>2:15 PM</span>
                <div class="ml-1 text-white">✓✓</div>
                </div>
            </div>
            </div>
            
            <div class="flex justify-center">
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                ⚡ Replied in 2 seconds
            </span>
            </div>
        </div>
        </div>

        <!-- Plumber SMS -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-sky-100 hover:scale-110 transition-transform duration-300">
        <div class="text-center mb-6">
            <div class="bg-sky-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
            <font-awesome-icon :icon="['fas', 'fa-robot']" class="text-sky-600 text-2xl" />
            </div>
            <h3 class="text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-sm text-slate-600">Plumber Example</p>
        </div>
        
        <div class="bg-white rounded-xl p-4 space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-3 py-2 max-w-xs">
                <p class="text-sm text-gray-800">Hot water system leaking, need urgent repair</p>
                <div class="text-xs text-gray-500 mt-1">9:22 PM</div>
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
            
            <div class="flex justify-end">
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-3 py-2 max-w-xs">
                <p class="text-sm text-white">No worries mate! Hot water repairs $420-$680 incl. callout. Can come out tonight if urgent. Give us a bell! - Mike</p>
                <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                <span>9:22 PM</span>
                <div class="ml-1 text-white">✓✓</div>
                </div>
            </div>
            </div>
            
            <div class="flex justify-center">
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                ⚡ Replied in 3 seconds
            </span>
            </div>
        </div>
        </div>

        <!-- Cleaner SMS -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-sky-100 hover:scale-110 transition-transform duration-300">
        <div class="text-center mb-6">
            <div class="bg-sky-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
            <font-awesome-icon :icon="['fas', 'fa-wand-sparkles']" class="text-sky-600 text-2xl" />
            </div>
            <h3 class="text-xl font-bold text-slate-900">SMS Response</h3>
            <p class="text-sm text-slate-600">Cleaner Example</p>
        </div>
        
        <div class="bg-white rounded-xl p-4 space-y-3">
            <div class="flex justify-start">
            <div class="bg-gray-200 rounded-2xl rounded-bl-md px-3 py-2 max-w-xs">
                <p class="text-sm text-gray-800">Bond clean for 3 bedroom house next week?</p>
                <div class="text-xs text-gray-500 mt-1">4:45 PM</div>
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
            
            <div class="flex justify-end">
            <div class="bg-blue-500 rounded-2xl rounded-br-md px-3 py-2 max-w-xs">
                <p class="text-sm text-white">Hi there! 3BR bond clean typically $680-$950. Includes all rooms, kitchen, bathrooms. Guaranteed to pass inspection! - Sarah</p>
                <div class="text-xs text-blue-200 mt-1 flex items-center justify-end">
                <span>4:45 PM</span>
                <div class="ml-1 text-white">✓✓</div>
                </div>
            </div>
            </div>
            
            <div class="flex justify-center">
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                ⚡ Replied in 4 seconds
            </span>
            </div>
        </div>
        </div>
    </div>

    <!-- Lead Generation Flow Chart -->
    <div class="bg-white rounded-2xl p-8 shadow-lg border border-sky-100">
        <div class="text-center mb-8">
        <h3 class="text-2xl font-bold text-slate-900 mb-2">Never Lose Work to Slow Responses Again</h3>
        <p class="text-slate-600">Two ways customers can reach you - both get instant professional replies</p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8">
        <!-- Website Forms Flow -->
        <div class="space-y-6">
            <div class="text-center">
            <div class="bg-sky-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-sky-600 text-2xl" />
            </div>
            <h4 class="text-xl font-bold text-slate-900">Website Forms</h4>
            </div>
            
            <div class="space-y-4">
            <div class="flex items-center gap-4 p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">1</div>
                <div>
                <p class="font-semibold text-slate-900">Embed Form on Website</p>
                <p class="text-sm text-slate-600">Add quote form to your site with one line of code</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">2</div>
                <div>
                <p class="font-semibold text-slate-900">Customer Submits Request</p>
                <p class="text-sm text-slate-600">Form captures project details and contact info</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">3</div>
                <div>
                <p class="font-semibold text-slate-900">AI Creates Professional Quote</p>
                <p class="text-sm text-slate-600">Using your pricing and business style</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">4</div>
                <div>
                <p class="font-semibold text-slate-900">Instant Email + SMS Response</p>
                <p class="text-sm text-slate-600">Customer gets quote in under 30 seconds</p>
                </div>
            </div>
            </div>
        </div>

        <!-- SMS Flow -->
        <div class="space-y-6">
            <div class="text-center">
            <div class="bg-sky-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                <font-awesome-icon :icon="['fas', 'fa-mobile-alt']" class="text-sky-600 text-2xl" />
            </div>
            <h4 class="text-xl font-bold text-slate-900">SMS Responses</h4>
            </div>
            
            <div class="space-y-4">
            <div class="flex items-center gap-4 p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">1</div>
                <div>
                <p class="font-semibold text-slate-900">Get Australian Phone Number</p>
                <p class="text-sm text-slate-600">Your dedicated business line for all trades</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">2</div>
                <div>
                <p class="font-semibold text-slate-900">Customer Texts Project Details</p>
                <p class="text-sm text-slate-600">Any time, day or night - even weekends</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-sky-50 rounded-lg">
                <div class="bg-sky-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">3</div>
                <div>
                <p class="font-semibold text-slate-900">AI Replies Instantly</p>
                <p class="text-sm text-slate-600">Professional quote with your voice and pricing</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">4</div>
                <div>
                <p class="font-semibold text-slate-900">Book More Jobs</p>
                <p class="text-sm text-slate-600">First to respond usually gets the work</p>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
</template>