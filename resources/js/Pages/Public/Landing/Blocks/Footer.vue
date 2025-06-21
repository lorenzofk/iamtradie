<script setup></script>

<template>
  <footer class="bg-slate-900 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Logo Section - Full width on mobile -->
      <div class="mb-6 sm:mb-8 lg:mb-0 lg:hidden">
        <div class="flex items-center mb-4">
          <img
            src="/images/logo.png"
            alt="PingMate Logo"
            class="bg-white rounded-lg p-2 h-16 w-16 sm:h-20 sm:w-20 transform scale-120"
          />
        </div>
        <p class="text-gray-400 text-sm leading-relaxed">
          AI-powered SMS responses for Australian workers. Never miss another lead.
        </p>
      </div>

      <!-- Main grid for larger screens -->
      <div class="hidden lg:grid lg:grid-cols-4 lg:gap-8">
        <div>
          <div class="flex items-center mb-4">
            <img
              src="/images/logo.png"
              alt="PingMate Logo"
              class="bg-white rounded-lg p-2 h-24 w-24 transform scale-120"
            />
          </div>
          <p class="text-gray-400 text-sm leading-relaxed">
            AI-powered SMS responses for Australian workers. Never miss another lead.
          </p>
        </div>

        <div>
          <h4 class="font-semibold mb-4">Product</h4>
          <ul class="space-y-2 text-sm text-gray-400">
            <li><a href="#solution" class="hover:text-white transition-colors">Solution</a></li>
            <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-4">Support</h4>
          <ul class="space-y-2 text-sm text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">Contact us</a></li>
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

      <!-- Mobile/Tablet 3-column grid for Product, Support, Legal -->
      <div class="grid grid-cols-3 gap-4 sm:gap-6 lg:hidden">
        <div>
          <h4 class="font-semibold mb-3 text-sm sm:text-base">Product</h4>
          <ul class="space-y-2 text-xs sm:text-sm text-gray-400">
            <li><a href="#solution" class="hover:text-white transition-colors">Solution</a></li>
            <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-3 text-sm sm:text-base">Support</h4>
          <ul class="space-y-2 text-xs sm:text-sm text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">Contact us</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-3 text-sm sm:text-base">Legal</h4>
          <ul class="space-y-2 text-xs sm:text-sm text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-800 mt-8 sm:mt-12 pt-6 sm:pt-8">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
          <p class="text-gray-400 text-sm text-center sm:text-left">© 2025 PingMate. All rights reserved.</p>
          <p class="text-gray-400 text-sm text-center sm:text-right">🇦🇺 Proudly Australian owned and operated.</p>
        </div>
      </div>
    </div>
  </footer>
</template>
