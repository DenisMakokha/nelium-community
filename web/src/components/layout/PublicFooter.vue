<template>
  <footer class="bg-navy-950 text-white py-16" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-8 mb-12">
        <div>
          <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-heading font-bold text-white">{{ brand.name }}</h3>
          </div>
          <p class="text-navy-200 leading-relaxed">Building stronger, more connected communities across Africa and beyond through innovative technology.</p>
        </div>
        <div>
          <h4 class="font-semibold text-lg mb-6 text-white">Platform</h4>
          <ul class="space-y-3 text-navy-200">
            <li><RouterLink to="/membership" class="hover:text-primary-400 transition-colors">Membership</RouterLink></li>
            <li><RouterLink to="/events" class="hover:text-primary-400 transition-colors">Events</RouterLink></li>
            <li><RouterLink to="/resources" class="hover:text-primary-400 transition-colors">Resources</RouterLink></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold text-lg mb-6 text-white">Company</h4>
          <ul class="space-y-3 text-navy-200">
            <li><RouterLink to="/about" class="hover:text-primary-400 transition-colors">About</RouterLink></li>
            <li><RouterLink to="/contact" class="hover:text-primary-400 transition-colors">Contact</RouterLink></li>
            <li><RouterLink to="/blog" class="hover:text-primary-400 transition-colors">Blog</RouterLink></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold text-lg mb-6 text-white">Contact</h4>
          <div class="space-y-3 text-navy-200">
            <p class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              {{ brand.footer.email }}
            </p>
            <p class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
              {{ brand.footer.phone }}
            </p>
          </div>
        </div>
      </div>
      <div class="border-t border-navy-700 pt-8 text-center text-navy-300">
        <p>&copy; 2025 {{ brand.name }}. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { brand } from '@/brand'
</script>
