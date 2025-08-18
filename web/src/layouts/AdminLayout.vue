<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-navy text-white shadow-sm" role="navigation">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <RouterLink to="/admin" class="text-xl font-bold text-white">
              {{ brand.name }} Admin
            </RouterLink>
            <div class="ml-10 flex items-baseline space-x-4">
              <RouterLink to="/admin" class="admin-nav-link" :class="{ active: $route.name === 'admin-dashboard' }">
                Dashboard
              </RouterLink>
              <RouterLink to="/admin/members" class="admin-nav-link" :class="{ active: $route.name === 'admin-members' }">
                Members
              </RouterLink>
              <RouterLink to="/admin/payments" class="admin-nav-link" :class="{ active: $route.name === 'admin-payments' }">
                Payments
              </RouterLink>
              <RouterLink to="/admin/reports" class="admin-nav-link" :class="{ active: $route.name === 'admin-reports' }">
                Reports
              </RouterLink>
              <RouterLink to="/admin/resources" class="admin-nav-link" :class="{ active: $route.name === 'admin-resources' }">
                Resources
              </RouterLink>
              <RouterLink to="/admin/events" class="admin-nav-link" :class="{ active: $route.name === 'admin-events' }">
                Events
              </RouterLink>
              <RouterLink to="/admin/announcements" class="admin-nav-link" :class="{ active: $route.name === 'admin-announcements' }">
                Announcements
              </RouterLink>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <RouterLink to="/portal" class="text-blue-200 hover:text-white text-sm">
              Back to Portal
            </RouterLink>
            <span class="text-sm text-blue-200">{{ authStore.user?.name }}</span>
            <div class="relative">
              <button @click="showDropdown = !showDropdown" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-white">
                <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center text-navy text-sm font-medium">
                  {{ authStore.user?.name?.charAt(0) || 'U' }}
                </div>
              </button>
              <div v-if="showDropdown" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                <div class="py-1">
                  <RouterLink to="/portal/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</RouterLink>
                  <button @click="handleLogout" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                </div>
              </div>
            </div>
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

const handleLogout = async () => {
  await authStore.logout()
  router.push('/')
}
</script>

<style scoped>
.admin-nav-link {
  @apply text-blue-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium;
}
.admin-nav-link.active {
  @apply text-white bg-blue-800;
}
</style>
