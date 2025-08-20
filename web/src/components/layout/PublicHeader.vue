<template>
  <nav class="bg-white/90 backdrop-blur-lg shadow-lg border-b border-white/20 sticky top-0 z-50" role="navigation" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <RouterLink to="/" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
              </svg>
            </div>
            <span class="text-2xl font-heading font-bold text-navy-900 group-hover:text-primary-600 transition-colors">{{ brand.name }}</span>
          </RouterLink>
        </div>
        <div class="hidden lg:flex items-center space-x-6">
          <RouterLink to="/about" class="text-navy-700 hover:text-primary-600 font-medium transition-colors">About</RouterLink>
          <RouterLink to="/membership" class="text-navy-700 hover:text-primary-600 font-medium transition-colors">Membership</RouterLink>
          <RouterLink to="/events" class="text-navy-700 hover:text-primary-600 font-medium transition-colors">Events</RouterLink>
          <RouterLink to="/resources" class="text-navy-700 hover:text-primary-600 font-medium transition-colors">Resources</RouterLink>
          <RouterLink to="/contact" class="text-navy-700 hover:text-primary-600 font-medium transition-colors">Contact</RouterLink>
          <RouterLink to="/login" class="px-4 py-2 text-navy-700 hover:text-primary-600 font-medium transition-colors">Login</RouterLink>
          <RouterLink to="/register" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-2 rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-lg">Join Now</RouterLink>
        </div>
        <div class="lg:hidden flex items-center">
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-navy-700 hover:bg-navy-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>
      <div v-if="mobileMenuOpen" class="lg:hidden py-4 border-t border-gray-200">
        <div class="flex flex-col space-y-3">
          <RouterLink to="/about" class="text-navy-700 hover:text-primary-600 font-medium transition-colors px-2 py-1">About</RouterLink>
          <RouterLink to="/membership" class="text-navy-700 hover:text-primary-600 font-medium transition-colors px-2 py-1">Membership</RouterLink>
          <RouterLink to="/events" class="text-navy-700 hover:text-primary-600 font-medium transition-colors px-2 py-1">Events</RouterLink>
          <RouterLink to="/resources" class="text-navy-700 hover:text-primary-600 font-medium transition-colors px-2 py-1">Resources</RouterLink>
          <RouterLink to="/contact" class="text-navy-700 hover:text-primary-600 font-medium transition-colors px-2 py-1">Contact</RouterLink>
          <div class="flex space-x-3 px-2 pt-3">
            <RouterLink to="/login" class="flex-1 text-center px-4 py-2 text-navy-700 border border-navy-300 rounded-xl font-medium hover:bg-navy-50 transition-colors">Login</RouterLink>
            <RouterLink to="/register" class="flex-1 text-center bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200">Join Now</RouterLink>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink } from 'vue-router'

const mobileMenuOpen = ref(false)

const brand = {
  name: 'Nelium Community'
}
</script>
