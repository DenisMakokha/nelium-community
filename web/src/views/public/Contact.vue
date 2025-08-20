<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <PublicHeader />
    
    <main class="py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h1 class="text-4xl md:text-5xl font-heading font-bold text-navy-900 mb-6">Contact Us</h1>
          <p class="text-xl text-navy-600 max-w-2xl mx-auto leading-relaxed">
            Get in touch with our team. We'd love to hear from you and help with any questions.
          </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12">
          <div class="bg-white rounded-2xl p-8 shadow-xl">
            <h2 class="text-2xl font-heading font-semibold text-navy-900 mb-6">Get in Touch</h2>
            <div class="space-y-6">
              <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-navy-900 mb-1">Email</h3>
                  <p class="text-navy-600">{{ brand.footer.email }}</p>
                </div>
              </div>
              
              <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-navy-900 mb-1">Phone</h3>
                  <p class="text-navy-600">{{ brand.footer.phone }}</p>
                </div>
              </div>
              
              <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-navy-900 mb-1">Location</h3>
                  <p class="text-navy-600">Serving communities across Africa</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-2xl p-8 shadow-xl">
            <h2 class="text-2xl font-heading font-semibold text-navy-900 mb-6">Send us a message</h2>
            <form class="space-y-6">
              <div>
                <label class="block text-sm font-medium text-navy-700 mb-2">Name</label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors" required>
              </div>
              <div>
                <label class="block text-sm font-medium text-navy-700 mb-2">Email</label>
                <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors" required>
              </div>
              <div>
                <label class="block text-sm font-medium text-navy-700 mb-2">Subject</label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors" required>
              </div>
              <div>
                <label class="block text-sm font-medium text-navy-700 mb-2">Message</label>
                <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors resize-none" required></textarea>
              </div>
              <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-lg">
                Send Message
              </button>
            </form>
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
import { brand } from '@/brand'
</script>
