<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <PublicHeader />

    <!-- Main Content -->
    <main id="main-content" class="flex-1">
      <!-- Hero Section -->
      <section class="relative bg-gradient-to-br from-navy-900 via-navy-800 to-primary-900 text-white py-24 lg:py-32 overflow-hidden" aria-labelledby="hero-heading">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
          <div class="absolute top-20 -left-20 w-96 h-96 bg-primary-400 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
          <div class="absolute top-20 -right-20 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
          <div class="absolute -bottom-20 left-1/2 transform -translate-x-1/2 w-96 h-96 bg-gold-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
          <div class="animate-fade-in">
            <h1 id="hero-heading" class="text-5xl md:text-7xl font-heading font-bold mb-8 bg-gradient-to-r from-white via-primary-100 to-emerald-100 bg-clip-text text-transparent">
              Build Stronger Communities
            </h1>
            <p class="text-xl md:text-2xl mb-12 text-navy-100 max-w-4xl mx-auto leading-relaxed">
              A secure, modern membership platform designed for networks and associations across Africa and beyond. Connect, grow, and thrive together.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
              <RouterLink to="/register" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-2xl transform">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Join the Community
              </RouterLink>
              <RouterLink to="/membership" class="bg-white/10 backdrop-blur-sm border border-white/20 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-white/20 transition-all duration-200 hover:scale-105">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View Plans
              </RouterLink>
            </div>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section class="py-24 bg-white relative" aria-labelledby="features-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-16 animate-slide-up">
            <h2 id="features-heading" class="text-4xl md:text-5xl font-heading font-bold text-navy-900 mb-6">
              Everything you need for your community
            </h2>
            <p class="text-xl text-navy-600 max-w-3xl mx-auto">
              Powerful tools designed to help you build, manage, and grow thriving communities with ease.
            </p>
          </div>
          <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
            <div class="group bg-gradient-to-br from-white to-primary-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 border border-primary-100">
              <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-semibold text-navy-900 mb-4 text-center">Member Management</h3>
              <p class="text-navy-600 text-center leading-relaxed">Comprehensive member directory with advanced privacy controls, tiered access levels, and seamless onboarding workflows.</p>
            </div>
            <div class="group bg-gradient-to-br from-white to-emerald-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 border border-emerald-100">
              <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-semibold text-navy-900 mb-4 text-center">Events & RSVP</h3>
              <p class="text-navy-600 text-center leading-relaxed">Organize memorable events with intelligent RSVP management, automated reminders, and real-time attendance tracking.</p>
            </div>
            <div class="group bg-gradient-to-br from-white to-gold-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 border border-gold-100">
              <div class="w-16 h-16 bg-gradient-to-r from-gold-500 to-gold-600 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-semibold text-navy-900 mb-4 text-center">Resource Library</h3>
              <p class="text-navy-600 text-center leading-relaxed">Secure document sharing platform with sophisticated tier-based access control and version management.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="bg-gradient-to-br from-navy-800 to-primary-800 py-24 relative overflow-hidden" aria-labelledby="cta-heading">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
          <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-400 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
          <div class="absolute bottom-10 right-10 w-72 h-72 bg-gold-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
        </div>
        
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
          <div class="animate-fade-in">
            <h2 id="cta-heading" class="text-4xl md:text-5xl font-heading font-bold text-white mb-6">
              Ready to build your community?
            </h2>
            <p class="text-xl text-navy-100 mb-12 max-w-2xl mx-auto leading-relaxed">
              Join thousands of organizations using Nelium to connect, engage, and grow their communities across Africa and beyond.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
              <RouterLink to="/register" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-2xl transform">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Get Started Free
              </RouterLink>
              <RouterLink to="/membership" class="bg-white/10 backdrop-blur-sm border border-white/20 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-white/20 transition-all duration-200 hover:scale-105">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                View Plans
              </RouterLink>
            </div>
          </div>
        </div>
      </section>
    </main>

    <PublicFooter />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
import { brand } from '@/brand'
import PublicHeader from '@/components/layout/PublicHeader.vue'
import PublicFooter from '@/components/layout/PublicFooter.vue'

const mobileMenuOpen = ref(false)
</script>
