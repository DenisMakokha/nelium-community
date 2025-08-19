<template>
  <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-aqua-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Welcome Header -->
      <div class="mb-10 text-center animate-fade-in">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-primary-500 to-aqua-500 rounded-full mb-4 shadow-lg">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </div>
        <h1 class="text-4xl font-heading font-semibold text-navy-900 mb-3">
          Welcome back, <span class="text-primary-600">{{ authStore.user?.name }}</span>! 👋
        </h1>
        <p class="text-lg text-navy-600 max-w-2xl mx-auto">
          Your community is thriving! Here's what's happening and how you can get involved today.
        </p>
      </div>

      <!-- Community Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 animate-slide-up">
        <!-- Upcoming Events Card -->
        <div class="group bg-white rounded-xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 hover:scale-105 border border-gray-100">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-navy-600 mb-1">Upcoming Events</p>
                <p class="text-3xl font-heading font-semibold text-navy-900">3</p>
                <p class="text-xs text-primary-600 font-medium">Don't miss out!</p>
              </div>
            </div>
            <div class="w-3 h-3 bg-primary-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
        </div>

        <!-- New Resources Card -->
        <div class="group bg-white rounded-xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 hover:scale-105 border border-gray-100">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 bg-gradient-to-r from-aqua-500 to-aqua-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-navy-600 mb-1">New Resources</p>
                <p class="text-3xl font-heading font-semibold text-navy-900">12</p>
                <p class="text-xs text-aqua-600 font-medium">Fresh content!</p>
              </div>
            </div>
            <div class="w-3 h-3 bg-aqua-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
        </div>

        <!-- Active Members Card -->
        <div class="group bg-white rounded-xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 hover:scale-105 border border-gray-100">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-navy-600 mb-1">Active Members</p>
                <p class="text-3xl font-heading font-semibold text-navy-900">1,247</p>
                <p class="text-xs text-emerald-600 font-medium">Growing strong!</p>
              </div>
            </div>
            <div class="w-3 h-3 bg-emerald-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
        </div>
      </div>

      <!-- Community Activity Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-up">
        <!-- Recent Announcements Card -->
        <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all duration-200 border border-gray-100">
          <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                  </svg>
                </div>
                <h3 class="text-xl font-heading font-semibold text-navy-900">Community Updates</h3>
              </div>
              <div class="w-3 h-3 bg-primary-500 rounded-full animate-pulse"></div>
            </div>
            <p class="text-navy-600 text-sm mt-1">Stay informed with the latest news</p>
          </div>
          <div class="p-6">
            <div class="space-y-5">
              <div class="group p-4 rounded-xl border-l-4 border-primary-500 bg-gradient-to-r from-primary-50 to-transparent hover:from-primary-100 transition-colors duration-200">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h4 class="font-semibold text-navy-900 mb-2 group-hover:text-primary-700 transition-colors">Welcome to Q1 2025 🎉</h4>
                    <p class="text-sm text-navy-600 mb-3">New year, new opportunities! Check out our upcoming events and fresh resources to kickstart your growth journey...</p>
                    <div class="flex items-center space-x-2">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                        Important
                      </span>
                      <span class="text-xs text-navy-500">2 days ago</span>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="group p-4 rounded-xl border-l-4 border-aqua-500 bg-gradient-to-r from-aqua-50 to-transparent hover:from-aqua-100 transition-colors duration-200">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h4 class="font-semibold text-navy-900 mb-2 group-hover:text-aqua-700 transition-colors">Resource Library Update 📚</h4>
                    <p class="text-sm text-navy-600 mb-3">We've added 15 new resources to help you grow your business. From marketing guides to financial planning tools...</p>
                    <div class="flex items-center space-x-2">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-aqua-100 text-aqua-800">
                        Resources
                      </span>
                      <span class="text-xs text-navy-500">1 week ago</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Upcoming Events Card -->
        <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all duration-200 border border-gray-100">
          <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <h3 class="text-xl font-heading font-semibold text-navy-900">Upcoming Events</h3>
              </div>
              <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
            </div>
            <p class="text-navy-600 text-sm mt-1">Connect and grow with your community</p>
          </div>
          <div class="p-6">
            <div class="space-y-4">
              <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-transparent rounded-xl hover:from-emerald-100 transition-all duration-200 border border-emerald-100">
                <div class="flex items-center space-x-4">
                  <div class="w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                    25
                  </div>
                  <div>
                    <h4 class="font-semibold text-navy-900 group-hover:text-emerald-700 transition-colors">Monthly Networking Mixer 🤝</h4>
                    <p class="text-sm text-navy-600">Jan 25, 2025 • 6:00 PM • Virtual</p>
                    <p class="text-xs text-emerald-600 font-medium">42 members attending</p>
                  </div>
                </div>
                <button class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 hover:scale-105 transform">
                  RSVP
                </button>
              </div>
              
              <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-primary-50 to-transparent rounded-xl hover:from-primary-100 transition-all duration-200 border border-primary-100">
                <div class="flex items-center space-x-4">
                  <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                    02
                  </div>
                  <div>
                    <h4 class="font-semibold text-navy-900 group-hover:text-primary-700 transition-colors">Business Growth Workshop 📈</h4>
                    <p class="text-sm text-navy-600">Feb 2, 2025 • 2:00 PM • In-person</p>
                    <p class="text-xs text-primary-600 font-medium">Limited seats available</p>
                  </div>
                </div>
                <button class="px-4 py-2 border-2 border-primary-500 text-primary-600 hover:bg-primary-500 hover:text-white text-sm font-medium rounded-lg transition-all duration-200 hover:scale-105 transform">
                  RSVP
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Community Actions -->
      <div class="mt-10 bg-gradient-to-r from-primary-500 to-aqua-500 rounded-2xl p-8 text-center animate-slide-up">
        <div class="max-w-3xl mx-auto">
          <h3 class="text-2xl font-heading font-semibold text-white mb-3">Ready to engage with your community?</h3>
          <p class="text-primary-100 text-lg mb-6">Explore resources, join events, and connect with fellow members to maximize your growth potential.</p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button class="px-6 py-3 bg-white text-primary-600 font-semibold rounded-xl hover:bg-primary-50 transition-all duration-200 hover:scale-105 transform shadow-lg">
              Browse Resources
            </button>
            <button class="px-6 py-3 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-primary-600 transition-all duration-200 hover:scale-105 transform">
              View All Events
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>
