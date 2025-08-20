<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <PublicHeader />
    
    <main class="py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h1 class="text-4xl md:text-5xl font-heading font-bold text-navy-900 mb-6">About Nelium Community</h1>
          <p class="text-xl text-navy-600 max-w-3xl mx-auto leading-relaxed">
            Empowering organizations to build stronger, more connected communities across Africa and beyond.
          </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
          <div>
            <h2 class="text-3xl font-heading font-semibold text-navy-900 mb-6">Our Mission</h2>
            <p class="text-lg text-navy-700 mb-6 leading-relaxed">
              Nelium Community is a modern, secure membership platform designed to help organizations 
              build and manage thriving communities with innovative technology solutions.
            </p>
            <p class="text-lg text-navy-700 leading-relaxed">
              Our platform provides comprehensive tools for member management, event organization, 
              resource sharing, and community engagement with enterprise-grade security and accessibility.
            </p>
          </div>
          <div class="bg-white rounded-2xl p-8 shadow-xl">
            <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center mb-6 mx-auto">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-navy-900 text-center mb-4">Community First</h3>
            <p class="text-navy-600 text-center">Building meaningful connections and fostering collaboration across diverse communities.</p>
          </div>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-navy-900 mb-3">Secure & Reliable</h3>
            <p class="text-navy-600">Enterprise-grade security with robust data protection and privacy controls.</p>
          </div>
          
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-12 h-12 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-navy-900 mb-3">Fast & Scalable</h3>
            <p class="text-navy-600">Built for performance with modern architecture that grows with your community.</p>
          </div>
          
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-navy-900 mb-3">User Focused</h3>
            <p class="text-navy-600">Intuitive design and seamless experience for both administrators and members.</p>
          </div>
        </div>
      </div>
    </main>
    
    <PublicFooter />
  </div>
</template>

<script setup lang="ts">
import PublicHeader from '@/components/layout/PublicHeader.vue'
import PublicFooter from '@/components/layout/PublicFooter.vue'
</script>
