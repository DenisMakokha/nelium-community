<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <PublicHeader />
    
    <main class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h1 class="text-4xl md:text-5xl font-heading font-bold text-navy-900 mb-6">Community Blog</h1>
          <p class="text-xl text-navy-600 max-w-3xl mx-auto leading-relaxed">
            Stay updated with the latest news, insights, and stories from our vibrant community.
          </p>
        </div>
        
        <!-- Coming Soon Section -->
        <div class="bg-white rounded-2xl p-12 shadow-xl text-center max-w-3xl mx-auto">
          <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-8 mx-auto">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
            </svg>
          </div>
          <h2 class="text-3xl font-heading font-bold text-navy-900 mb-4">Coming Soon</h2>
          <p class="text-lg text-navy-600 mb-8 leading-relaxed">
            We're working on bringing you engaging content, community stories, and valuable insights. 
            Our blog will feature articles from community members, industry experts, and thought leaders.
          </p>
          <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="text-center">
              <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center mb-3 mx-auto">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                </svg>
              </div>
              <h3 class="font-semibold text-navy-900 mb-2">Community Stories</h3>
              <p class="text-sm text-navy-600">Member spotlights and success stories</p>
            </div>
            <div class="text-center">
              <div class="w-12 h-12 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg flex items-center justify-center mb-3 mx-auto">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
              </div>
              <h3 class="font-semibold text-navy-900 mb-2">Industry Insights</h3>
              <p class="text-sm text-navy-600">Expert analysis and trends</p>
            </div>
            <div class="text-center">
              <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mb-3 mx-auto">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <h3 class="font-semibold text-navy-900 mb-2">How-To Guides</h3>
              <p class="text-sm text-navy-600">Practical tips and tutorials</p>
            </div>
          </div>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <RouterLink to="/register" class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-lg">
              Join Community
            </RouterLink>
            <RouterLink to="/contact" class="px-8 py-3 border-2 border-navy-300 text-navy-700 rounded-xl font-semibold hover:bg-navy-50 transition-colors">
              Get Notified
            </RouterLink>
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
