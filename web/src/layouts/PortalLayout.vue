<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b" role="navigation">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <RouterLink to="/portal" class="text-xl font-bold text-navy">
              {{ brand.name }}
            </RouterLink>
            <div class="ml-10 flex items-baseline space-x-4">
              <RouterLink to="/portal" class="nav-link" :class="{ active: $route.name === 'dashboard' }">
                Dashboard
              </RouterLink>
              <RouterLink to="/portal/resources" class="nav-link" :class="{ active: $route.name === 'portal-resources' }">
                Resources
              </RouterLink>
              <RouterLink to="/portal/events" class="nav-link" :class="{ active: $route.name === 'portal-events' }">
                Events
              </RouterLink>
              <RouterLink to="/portal/directory" class="nav-link" :class="{ active: $route.name === 'directory' }">
                Directory
              </RouterLink>
              <!-- Admin-only navigation -->
              <RouterLink v-if="authStore.isAdmin" to="/admin" class="nav-link admin-highlight" :class="{ active: $route.path.startsWith('/admin') }">
                Admin Panel
              </RouterLink>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">{{ authStore.user?.name }}</span>
            <div class="relative">
              <button @click="showDropdown = !showDropdown" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blueA">
                <div class="h-8 w-8 rounded-full bg-blueA flex items-center justify-center text-white text-sm font-medium">
                  {{ authStore.user?.name?.charAt(0) || 'U' }}
                </div>
              </button>
              <div v-if="showDropdown" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                <div class="py-1">
                  <RouterLink to="/portal/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</RouterLink>
                  <RouterLink to="/portal/billing" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Billing</RouterLink>
                  <RouterLink v-if="authStore.isAdmin" to="/admin" class="block px-4 py-2 text-sm text-orange-600 hover:bg-orange-50 font-medium">Admin Panel</RouterLink>
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
.nav-link {
  @apply text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium;
}
.nav-link.active {
  @apply text-blueA bg-blue-50;
}
.admin-highlight {
  @apply text-orange-600 hover:text-orange-700 bg-orange-50 border border-orange-200;
}
</style>
