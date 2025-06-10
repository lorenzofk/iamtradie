<script setup>
import { Head } from '@inertiajs/vue3';
import Pricing from './Blocks/Pricing.vue';
import Footer from './Blocks/Footer.vue';
import Header from './Blocks/Header.vue';
import Hero from './Blocks/Hero.vue';
import HowItWorks from './Blocks/HowItWorks.vue';
import Problem from './Blocks/Problem.vue';
import CallToAction from './Blocks/CallToAction.vue';

const scrollToSection = (sectionId) => {
  const element = document.getElementById(sectionId);
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>

<template>
  <Head title="PingMate - AI Quote System for Australian Tradies">
    <meta name="description" content="AI responds to customer texts in seconds with professional quotes using your pricing. Get your own Australian phone number and embedded website forms." />
  </Head>

  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800">
    <Header @scroll-to-section="scrollToSection" />

    <section class="relative py-12 overflow-hidden">
      <Hero @scroll-to-section="scrollToSection" />
    </section>

    <section id="how-it-works" class="py-12 bg-gradient-to-br from-slate-50 to-sky-50">
      <HowItWorks />
    </section>

    <!-- Problem Section -->
    <section id="problem" class="py-16 bg-gradient-to-br from-red-500 via-pink-600 to-purple-700">
      <Problem />
    </section>


    <!-- Pricing Section -->
    <section id="pricing" class="py-16 bg-gradient-to-br from-slate-50 to-blue-200">
      <Pricing />
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-green-600">
      <CallToAction @scroll-to-section="scrollToSection" />
    </section>

    <!-- Footer -->
    <Footer />
  </div>
</template>