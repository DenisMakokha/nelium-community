<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <!-- Navigation -->
    <nav class="bg-navy-900 text-white shadow-xl border-b border-navy-800" role="navigation">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Logo and Navigation Links -->
          <div class="flex items-center">
            <RouterLink to="/admin" class="flex items-center space-x-3 group">
              <div class="w-8 h-8 bg-gradient-to-r from-primary-500 to-aqua-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <span class="text-xl font-heading font-semibold text-white group-hover:text-primary-200 transition-colors">
                {{ brand.name }}
              </span>
            </RouterLink>
            
            <!-- Desktop Navigation -->
            <div class="hidden lg:ml-10 lg:flex lg:items-baseline lg:space-x-1">
              <RouterLink to="/admin" class="admin-nav-link" :class="{ active: $route.name === 'admin-dashboard' }">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0"></path>
                </svg>
                Dashboard
              </RouterLink>
              <RouterLink to="/admin/members" class="admin-nav-link" :class="{ active: $route.name === 'admin-members' }">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Members
              </RouterLink>
              <RouterLink to="/admin/payments" class="admin-nav-link" :class="{ active: $route.name === 'admin-payments' }">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                Payments
              </RouterLink>
              <RouterLink to="/admin/reports" class="admin-nav-link" :class="{ active: $route.name === 'admin-reports' }">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Reports
              </RouterLink>
              <RouterLink to="/admin/resources" class="admin-nav-link" :class="{ active: $route.name === 'admin-resources' }">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Resources
              </RouterLink>
              <RouterLink to="/admin/events" class="admin-nav-link" :class="{ active: $route.name === 'admin-events' }">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Events
              </RouterLink>
              <RouterLink to="/admin/announcements" class="admin-nav-link" :class="{ active: $route.name === 'admin-announcements' }">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
                Announcements
              </RouterLink>
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden ml-4">
              <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-md text-navy-300 hover:text-white hover:bg-navy-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                  <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Right Side Actions -->
          <div class="flex items-center space-x-4">
            <RouterLink to="/portal" class="hidden sm:flex items-center space-x-2 text-navy-300 hover:text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-navy-800 transition-all">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
              </svg>
              Back to Portal
            </RouterLink>
            
            <!-- User Menu -->
            <div class="relative">
              <button @click="showDropdown = !showDropdown" class="flex items-center space-x-3 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-400 p-2 hover:bg-navy-800 transition-colors">
                <div class="h-8 w-8 rounded-lg bg-gradient-to-r from-primary-500 to-aqua-500 flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                  {{ authStore.user?.name?.charAt(0) || 'U' }}
                </div>
                <span class="hidden sm:block text-navy-200 font-medium">{{ authStore.user?.name }}</span>
                <svg class="w-4 h-4 text-navy-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>
              
              <div v-if="showDropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 border border-gray-200 z-50">
                <div class="py-2">
                  <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-medium text-navy-900">{{ authStore.user?.name }}</p>
                    <p class="text-xs text-navy-600">Administrator</p>
                  </div>
                  <RouterLink to="/portal/profile" class="flex items-center px-4 py-3 text-sm text-navy-700 hover:bg-navy-50 transition-colors">
                    <svg class="w-4 h-4 mr-3 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile Settings
                  </RouterLink>
                  <button @click="handleLogout" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Sign out
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div v-if="mobileMenuOpen" class="lg:hidden border-t border-navy-800 mt-2 pt-4 pb-4">
          <div class="space-y-1">
            <RouterLink to="/admin" class="mobile-nav-link" :class="{ active: $route.name === 'admin-dashboard' }" @click="mobileMenuOpen = false">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0"></path>
              </svg>
              Dashboard
            </RouterLink>
            <RouterLink to="/admin/members" class="mobile-nav-link" :class="{ active: $route.name === 'admin-members' }" @click="mobileMenuOpen = false">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              Members
            </RouterLink>
            <RouterLink to="/admin/payments" class="mobile-nav-link" :class="{ active: $route.name === 'admin-payments' }" @click="mobileMenuOpen = false">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
              Payments
            </RouterLink>
            <RouterLink to="/admin/reports" class="mobile-nav-link" :class="{ active: $route.name === 'admin-reports' }" @click="mobileMenuOpen = false">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
              </svg>
              Reports
            </RouterLink>
            <RouterLink to="/admin/resources" class="mobile-nav-link" :class="{ active: $route.name === 'admin-resources' }" @click="mobileMenuOpen = false">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Resources
            </RouterLink>
            <RouterLink to="/admin/events" class="mobile-nav-link" :class="{ active: $route.name === 'admin-events' }" @click="mobileMenuOpen = false">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Events
            </RouterLink>
            <RouterLink to="/admin/announcements" class="mobile-nav-link" :class="{ active: $route.name === 'admin-announcements' }" @click="mobileMenuOpen = false">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
              </svg>
              Announcements
            </RouterLink>
            <RouterLink to="/portal" class="mobile-nav-link border-t border-navy-800 mt-2 pt-2" @click="mobileMenuOpen = false">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
              </svg>
              Back to Portal
            </RouterLink>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content" class="flex-1">
      <RouterView />
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink, RouterView, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { brand } from '@/brand'

const router = useRouter()
const authStore = useAuthStore()
const showDropdown = ref(false)
const mobileMenuOpen = ref(false)

const handleLogout = async () => {
  await authStore.logout()
  router.push('/')
}
</script>

<style scoped>
.admin-nav-link {
  @apply flex items-center text-navy-300 hover:text-white hover:bg-navy-800 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200;
}
.admin-nav-link.active {
  @apply text-white bg-gradient-to-r from-primary-600 to-primary-700 shadow-sm;
}
.mobile-nav-link {
  @apply flex items-center text-navy-300 hover:text-white hover:bg-navy-800 px-3 py-3 rounded-lg text-sm font-medium transition-all duration-200;
}
.mobile-nav-link.active {
  @apply text-white bg-gradient-to-r from-primary-600 to-primary-700 shadow-sm;
}
</style>
