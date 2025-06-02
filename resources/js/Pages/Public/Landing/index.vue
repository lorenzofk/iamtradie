<script setup>
import { Head } from '@inertiajs/vue3';

const scrollToSection = (sectionId) => {
  const element = document.getElementById(sectionId);
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>

<template>
  <Head title="I am Tradie - AI Quote System for Australian Tradies">
    <meta name="description" content="AI responds to customer texts in seconds with professional quotes using your pricing. Get your own Australian phone number and embedded website forms." />
  </Head>

  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800">
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center">
            <div class="bg-gradient-to-r from-blue-600 to-green-600 p-2 rounded-xl mr-3">
              <i class="fas fa-bolt h-6 w-6 text-white"></i>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">I am Tradie</span>
          </div>
          <nav class="hidden md:flex space-x-8">
            <a href="#problem" @click.prevent="scrollToSection('problem')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">The Problem</a>
            <a href="#solution" @click.prevent="scrollToSection('solution')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">How It Works</a>
            <a href="#pricing" @click.prevent="scrollToSection('pricing')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Pricing</a>
          </nav>
          <div class="flex space-x-4">
            <a href="/login" class="inline-flex items-center px-4 py-2 border border-blue-600 rounded-md text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 transition-colors">
              Login
            </a>
            <a href="/login" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 shadow-lg transition-all">
              Get Started Free
            </a>
          </div>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="relative py-12 overflow-hidden">
      <!-- Animated Background -->
      <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-green-600/20"></div>
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1000ms"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 500ms"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-6">
          <span class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-6 py-3 rounded-full text-sm font-semibold shadow-lg">
            🇦🇺 Made for Australian Tradies
          </span>
        </div>
        <h1 class="text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
          Never Miss Another SMS<br />
          <span class="bg-gradient-to-r from-sky-400 to-blue-400 bg-clip-text text-transparent">While Competitors Sleep</span>
        </h1>
        <p class="text-xl text-blue-100 mb-8 max-w-4xl mx-auto leading-relaxed">
          AI responds to customer texts in seconds with professional quotes using your pricing. Get your own Australian phone number and embedded website forms. 
          <span class="text-yellow-300 font-semibold">First to reply usually gets the job.</span>
        </p>
        
        <!-- Social Proof -->
        <div class="mb-8">
          <p class="text-lg text-blue-200 mb-4">Trusted by 200+ Australian tradies</p>
          <div class="flex justify-center items-center space-x-8">
            <div class="text-2xl">⭐⭐⭐⭐⭐</div>
            <div class="text-lg text-blue-200 font-medium">4.9/5 on reviews</div>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-6 mb-12">
          <a href="/login" class="inline-flex items-center justify-center px-12 py-4 text-lg bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold">
            Start Free 14-Day Trial
          </a>
          <button @click="scrollToSection('how-it-works')" class="inline-flex items-center justify-center px-12 py-4 text-lg border-2 border-sky-400/80 text-sky-200 bg-sky-500/10 backdrop-blur-sm hover:bg-sky-400 hover:text-slate-900 shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold">
            <font-awesome-icon :icon="['fas', 'fa-comments']" class="h-5 w-5 mr-2" />
            See How It Works
          </button>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-16 bg-gradient-to-br from-slate-50 to-sky-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-slate-900 mb-4">
            Beat Competitors with Lightning-Fast SMS Replies
          </h2>
          <p class="text-xl text-slate-600 max-w-3xl mx-auto">
            Customer texts you at 9 PM? AI replies instantly with a professional quote using your rates. Weekend inquiry? No worries, you're always first to respond.
          </p>
        </div>
        
        <!-- SMS Examples Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
          <!-- Electrician SMS -->
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-sky-100">
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
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-sky-100">
            <div class="text-center mb-6">
              <div class="bg-sky-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                <font-awesome-icon :icon="['fas', 'fa-users']" class="text-sky-600 text-2xl" />
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
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-sky-100">
            <div class="text-center mb-6">
              <div class="bg-sky-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                <font-awesome-icon :icon="['fas', 'fa-shield-alt']" class="text-sky-600 text-2xl" />
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
    </section>

    <!-- Problem Section -->
    <section id="problem" class="py-24 bg-gradient-to-br from-red-500 via-pink-600 to-purple-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
          <h2 class="text-5xl md:text-6xl font-black text-white mb-6">
            The $500 Text Message Problem
          </h2>
          <p class="text-2xl text-red-100 max-w-3xl mx-auto">
            Every delayed SMS reply costs you real money. Here's how it happens...
          </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          <div class="space-y-8">
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20">
              <div class="flex items-start">
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl p-4 mr-6 mt-1">
                  <font-awesome-icon :icon="['fas', 'fa-clock']" class="text-white text-2xl" />
                </div>
                <div>
                  <h3 class="text-2xl font-bold text-white mb-3">8:30 PM Saturday Night</h3>
                  <p class="text-red-100 text-lg leading-relaxed">"Need urgent plumber - hot water system broken, family visiting tomorrow"</p>
                </div>
              </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20">
              <div class="flex items-start">
                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-4 mr-6 mt-1">
                  <font-awesome-icon :icon="['fas', 'fa-times']" class="text-white text-2xl" />
                </div>
                <div>
                  <h3 class="text-2xl font-bold text-white mb-3">You're Having Dinner</h3>
                  <p class="text-red-100 text-lg leading-relaxed">Phone on silent. Family time is sacred. You'll check messages later.</p>
                </div>
              </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20">
              <div class="flex items-start">
                <div class="bg-gradient-to-r from-gray-600 to-gray-700 rounded-2xl p-4 mr-6 mt-1">
                  <font-awesome-icon :icon="['fas', 'fa-dollar-sign']" class="text-white text-2xl" />
                </div>
                <div>
                  <h3 class="text-2xl font-bold text-white mb-3">Next Morning: "Job Filled"</h3>
                  <p class="text-red-100 text-lg leading-relaxed">Customer already booked someone else. You lost a $500-800 emergency job.</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-10 border border-white/20">
            <h3 class="text-3xl font-black text-gray-900 mb-8 text-center">This Happens Every Week</h3>
            <div class="space-y-6">
              <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-700 text-lg font-medium">Lost weekend jobs</span>
                <span class="font-bold text-xl text-red-600">2-3 per month</span>
              </div>
              <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-700 text-lg font-medium">Average job value</span>
                <span class="font-bold text-xl text-gray-900">$400-800</span>
              </div>
              <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-700 text-lg font-medium">Monthly lost revenue</span>
                <span class="font-bold text-2xl text-red-600">$1,200-2,400</span>
              </div>
              <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-2xl p-6 mt-6">
                <div class="flex justify-between items-center">
                  <span class="font-bold text-xl text-gray-900">Yearly opportunity cost</span>
                  <span class="font-black text-3xl text-red-600">$15,000-30,000</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Solution Section -->
    <section id="solution" class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-900 mb-4">
            I am Tradie: Your AI That Never Sleeps
          </h2>
          <p class="text-xl text-gray-600">
            Capture every lead with instant, professional responses using I am Tradie
          </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div class="bg-green-50 rounded-2xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-green-800 mb-6">Same Scenario With I am Tradie</h3>
            <div class="space-y-4">
              <div class="flex items-start">
                <div class="bg-green-100 rounded-full p-2 mr-4 mt-1">
                  <font-awesome-icon :icon="['fas', 'fa-comments']" class="text-green-600" />
                </div>
                <div>
                  <h4 class="font-semibold text-green-800">8:30 PM: Customer texts</h4>
                  <p class="text-green-700 text-sm">Same urgent hot water problem</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="bg-green-100 rounded-full p-2 mr-4 mt-1">
                  <font-awesome-icon :icon="['fas', 'fa-bolt']" class="text-green-600" />
                </div>
                <div>
                  <h4 class="font-semibold text-green-800">8:30:03 PM: AI responds</h4>
                  <p class="text-green-700 text-sm">"G'day! Hot water repairs typically $420-680 incl. callout. Emergency available tonight. Can I book you in? Cheers, Dave."</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="bg-green-100 rounded-full p-2 mr-4 mt-1">
                  <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-600" />
                </div>
                <div>
                  <h4 class="font-semibold text-green-800">8:35 PM: Job booked</h4>
                  <p class="text-green-700 text-sm">Customer replies to book. You check phone after dinner, confirm time.</p>
                </div>
              </div>
              
              <div class="bg-green-100 rounded-lg p-4 mt-6">
                <div class="text-center">
                  <div class="text-3xl font-bold text-green-800">$650 Job Secured</div>
                  <div class="text-green-700">While you enjoyed dinner</div>
                </div>
              </div>
            </div>
          </div>
          
          <div>
            <h3 class="text-2xl font-bold text-gray-900 mb-6">
              How TradieQuote AI Works
            </h3>
            <div class="space-y-6">
              <div class="flex items-start">
                <div class="bg-orange-100 rounded-full w-12 h-12 flex items-center justify-center mr-4 mt-1">
                  <span class="font-bold text-orange-600">1</span>
                </div>
                <div>
                  <h4 class="text-lg font-semibold text-gray-900 mb-2">Your Australian Business Number</h4>
                  <p class="text-gray-600">We give you a local Aussie number. Customers text you directly - no app downloads or complicated setup.</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="bg-orange-100 rounded-full w-12 h-12 flex items-center justify-center mr-4 mt-1">
                  <span class="font-bold text-orange-600">2</span>
                </div>
                <div>
                  <h4 class="text-lg font-semibold text-gray-900 mb-2">AI Reads & Understands</h4>
                  <p class="text-gray-600">Smart AI instantly understands what job they need and calculates quotes using YOUR actual callout fees and hourly rates.</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="bg-orange-100 rounded-full w-12 h-12 flex items-center justify-center mr-4 mt-1">
                  <span class="font-bold text-orange-600">3</span>
                </div>
                <div>
                  <h4 class="text-lg font-semibold text-gray-900 mb-2">Professional Reply in Seconds</h4>
                  <p class="text-gray-600">AI replies using your business voice - casual, professional, or polite. Customers think you responded personally.</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="bg-orange-100 rounded-full w-12 h-12 flex items-center justify-center mr-4 mt-1">
                  <span class="font-bold text-orange-600">4</span>
                </div>
                <div>
                  <h4 class="text-lg font-semibold text-gray-900 mb-2">You Win More Work</h4>
                  <p class="text-gray-600">Be first to respond, every time. Win jobs while competitors are asleep, at dinner, or busy on other sites.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gradient-to-br from-slate-50 to-blue-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-900 mb-4">
            Simple Pricing That Pays for Itself
          </h2>
          <p class="text-xl text-gray-600">
            Win just one extra job per month and it's paid for itself
          </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Starter Plan -->
          <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
            <div class="text-center mb-8">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
              <div class="text-4xl font-black text-gray-900 mb-2">$47<span class="text-lg font-medium text-gray-600">/month</span></div>
              <p class="text-gray-600">Perfect for solo tradies</p>
            </div>
            
            <ul class="space-y-4 mb-8">
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>Australian SMS number</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>500 AI responses/month</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>Website embed forms</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>Basic reporting</span>
              </li>
            </ul>
            
            <a :href="route('onboarding.show', 'starter')"  class="w-full block text-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-md font-medium transition-colors">
              Start Free Trial
            </a>
          </div>

          <!-- Professional Plan (Featured) -->
          <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-xl p-8 border-2 border-blue-500 relative">
            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
              <span class="bg-yellow-400 text-yellow-900 px-4 py-1 rounded-full text-sm font-bold">Most Popular</span>
            </div>
            
            <div class="text-center mb-8">
              <h3 class="text-2xl font-bold text-white mb-2">Professional</h3>
              <div class="text-4xl font-black text-white mb-2">$97<span class="text-lg font-medium text-blue-200">/month</span></div>
              <p class="text-blue-100">For growing businesses</p>
            </div>
            
            <ul class="space-y-4 mb-8 text-white">
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-yellow-400 mr-3" />
                <span>Australian SMS number</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-yellow-400 mr-3" />
                <span>2,000 AI responses/month</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-yellow-400 mr-3" />
                <span>Unlimited website forms</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-yellow-400 mr-3" />
                <span>Advanced analytics</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-yellow-400 mr-3" />
                <span>Email support</span>
              </li>
            </ul>
            
            <a :href="route('onboarding.show', 'professional')" class="w-full block text-center px-4 py-2 bg-yellow-400 hover:bg-yellow-300 text-yellow-900 rounded-md font-bold transition-colors">
              Start Free Trial
            </a>
          </div>

          <!-- Enterprise Plan -->
          <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
            <div class="text-center mb-8">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
              <div class="text-4xl font-black text-gray-900 mb-2">$197<span class="text-lg font-medium text-gray-600">/month</span></div>
              <p class="text-gray-600">For large operations</p>
            </div>
            
            <ul class="space-y-4 mb-8">
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>Multiple SMS numbers</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>Unlimited AI responses</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>Team management</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>Priority support</span>
              </li>
              <li class="flex items-center">
                <font-awesome-icon :icon="['fas', 'fa-check']" class="text-green-500 mr-3" />
                <span>Custom integrations</span>
              </li>
            </ul>
            
            <a :href="route('onboarding.show', 'enterprise')" class="w-full block text-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-md font-medium transition-colors">
              Contact Sales
            </a>
          </div>
        </div>
        
        <div class="text-center mt-12">
          <p class="text-gray-600 mb-4">14-day free trial. No credit card required. Cancel anytime.</p>
          <div class="flex justify-center items-center space-x-8">
            <div class="flex items-center">
              <font-awesome-icon :icon="['fas', 'fa-shield-alt']" class="text-green-500 mr-2" />
              <span class="text-gray-700">30-day money-back guarantee</span>
            </div>
            <div class="flex items-center">
              <font-awesome-icon :icon="['fas', 'fa-phone']" class="text-green-500 mr-2" />
              <span class="text-gray-700">Australian support team</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-green-600">
      <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
          Stop Losing Jobs to Faster Competitors
        </h2>
        <p class="text-xl text-blue-100 mb-8 leading-relaxed">
          Join 200+ Australian tradies who never miss another SMS lead. 
          <span class="text-yellow-300 font-semibold">Start your free trial today.</span>
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-6">
          <a href="/login" class="inline-flex items-center justify-center px-12 py-4 text-lg bg-white hover:bg-gray-100 text-blue-600 shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold">
            Start Free 14-Day Trial
          </a>
          <button @click="scrollToSection('how-it-works')" class="inline-flex items-center justify-center px-12 py-4 text-lg border-2 border-white text-white hover:bg-white hover:text-blue-600 shadow-2xl transform hover:scale-105 transition-all duration-200 rounded-2xl font-bold">
            Learn More
          </button>
        </div>
        
        <p class="text-blue-200 mt-6 text-sm">
          ✓ No credit card required ✓ Australian phone number included ✓ Cancel anytime
        </p>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            <div class="flex items-center mb-4">
              <div class="bg-gradient-to-r from-blue-600 to-green-600 p-2 rounded-xl mr-3">
                <font-awesome-icon :icon="['fas', 'fa-bolt']" class="text-white" />
              </div>
              <span class="text-xl font-bold">I am Tradie</span>
            </div>
            <p class="text-gray-400 text-sm leading-relaxed">
              AI-powered SMS responses for Australian tradies. Never miss another lead.
            </p>
          </div>
          
          <div>
            <h4 class="font-semibold mb-4">Product</h4>
            <ul class="space-y-2 text-sm text-gray-400">
              <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
              <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
              <li><a href="#" class="hover:text-white transition-colors">API</a></li>
            </ul>
          </div>
          
          <div>
            <h4 class="font-semibold mb-4">Support</h4>
            <ul class="space-y-2 text-sm text-gray-400">
              <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
              <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
              <li><a href="#" class="hover:text-white transition-colors">Status</a></li>
            </ul>
          </div>
          
          <div>
            <h4 class="font-semibold mb-4">Legal</h4>
            <ul class="space-y-2 text-sm text-gray-400">
              <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
              <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
              <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
            </ul>
          </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8">
          <div class="flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
              © 2024 I am Tradie. All rights reserved.
            </p>
            <p class="text-gray-400 text-sm mt-4 md:mt-0">
              🇦🇺 Proudly Australian owned and operated
            </p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>