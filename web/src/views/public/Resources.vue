<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <PublicHeader />
    
    <main class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h1 class="text-4xl md:text-5xl font-heading font-bold text-navy-900 mb-6">Resource Library</h1>
          <p class="text-xl text-navy-600 max-w-3xl mx-auto leading-relaxed mb-8">
            Access our comprehensive collection of resources, guides, and materials to support your growth and development.
          </p>
          <div class="bg-white rounded-2xl p-8 shadow-xl max-w-2xl mx-auto">
            <div class="flex items-center justify-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <h2 class="text-2xl font-heading font-semibold text-navy-900">Unlock Full Access</h2>
            </div>
            <p class="text-navy-600 mb-6">
              <RouterLink to="/login" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">Login</RouterLink> 
              to access our full resource library with exclusive member content, or 
              <RouterLink to="/register" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">become a member</RouterLink> 
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
        
        <!-- Resource Categories Preview -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="bg-white rounded-2xl p-6 shadow-xl">
            <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-navy-900 mb-3">Guides & Tutorials</h3>
            <p class="text-navy-600 text-sm mb-4">Step-by-step guides and comprehensive tutorials to help you master new skills.</p>
            <div class="text-xs text-navy-500">20+ Resources</div>
          </div>
          
          <div class="bg-white rounded-2xl p-6 shadow-xl">
            <div class="w-12 h-12 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-navy-900 mb-3">Templates</h3>
            <p class="text-navy-600 text-sm mb-4">Ready-to-use templates and frameworks to accelerate your projects and workflows.</p>
            <div class="text-xs text-navy-500">15+ Templates</div>
          </div>
          
          <div class="bg-white rounded-2xl p-6 shadow-xl">
            <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2M9 12h6"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-navy-900 mb-3">Research Papers</h3>
            <p class="text-navy-600 text-sm mb-4">In-depth research and analysis on industry trends and best practices.</p>
            <div class="text-xs text-navy-500">10+ Papers</div>
          </div>
          
          <div class="bg-white rounded-2xl p-6 shadow-xl">
            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-navy-900 mb-3">Video Content</h3>
            <p class="text-navy-600 text-sm mb-4">Educational videos, webinars, and recorded sessions from expert speakers.</p>
            <div class="text-xs text-navy-500">25+ Videos</div>
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
