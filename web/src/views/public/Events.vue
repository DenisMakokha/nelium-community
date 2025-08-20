<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <PublicHeader />
    
    <main class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h1 class="text-4xl md:text-5xl font-heading font-bold text-navy-900 mb-6">Upcoming Events</h1>
          <p class="text-xl text-navy-600 max-w-3xl mx-auto leading-relaxed mb-8">
            Discover and join our community events. Connect with like-minded individuals and expand your network.
          </p>
          <div class="bg-white rounded-2xl p-8 shadow-xl max-w-2xl mx-auto">
            <div class="flex items-center justify-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <h2 class="text-2xl font-heading font-semibold text-navy-900">Join Our Community</h2>
            </div>
            <p class="text-navy-600 mb-6">
              <RouterLink to="/login" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">Login</RouterLink> 
              to RSVP for events and access exclusive member-only gatherings, or 
              <RouterLink to="/register" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">join our community</RouterLink> 
              to get started.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
              <RouterLink to="/login" class="flex-1 px-6 py-3 border-2 border-primary-500 text-primary-600 rounded-xl font-semibold hover:bg-primary-50 transition-colors text-center">
                Login
              </RouterLink>
              <RouterLink to="/register" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-lg text-center">
                Join Now
              </RouterLink>
            </div>
          </div>
        </div>
        
        <!-- Preview Events Section -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="bg-white rounded-2xl p-6 shadow-xl">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-navy-900">Networking Events</h3>
                <p class="text-sm text-navy-500">Monthly</p>
              </div>
            </div>
            <p class="text-navy-600 mb-4">Connect with professionals and expand your network through our regular networking sessions.</p>
            <div class="text-sm text-navy-500">Next: TBA</div>
          </div>
          
          <div class="bg-white rounded-2xl p-6 shadow-xl">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-navy-900">Workshops</h3>
                <p class="text-sm text-navy-500">Bi-weekly</p>
              </div>
            </div>
            <p class="text-navy-600 mb-4">Learn new skills and enhance your expertise through hands-on workshops and training sessions.</p>
            <div class="text-sm text-navy-500">Next: TBA</div>
          </div>
          
          <div class="bg-white rounded-2xl p-6 shadow-xl">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-navy-900">Community Meetups</h3>
                <p class="text-sm text-navy-500">Weekly</p>
              </div>
            </div>
            <p class="text-navy-600 mb-4">Casual gatherings to discuss ideas, share experiences, and build lasting relationships.</p>
            <div class="text-sm text-navy-500">Next: TBA</div>
          </div>
        </div>
      </div>
    </main>
    
    <PublicFooter />
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
import PublicHeader from '@/components/layout/PublicHeader.vue'
import PublicFooter from '@/components/layout/PublicFooter.vue'
</script>
