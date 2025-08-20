<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-900 via-navy-800 to-primary-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-0 -left-4 w-72 h-72 bg-primary-300 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
      <div class="absolute top-0 -right-4 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
      <div class="absolute -bottom-8 left-20 w-72 h-72 bg-gold-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="max-w-md w-full space-y-8 relative z-10">
      <!-- Logo/Brand Section -->
      <div class="text-center">
        <div class="mx-auto h-16 w-16 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-2xl mb-6 transform hover:scale-105 transition-transform">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
          </svg>
        </div>
        <h2 class="text-4xl font-heading font-bold text-white mb-2">
          Welcome Back
        </h2>
        <p class="text-navy-200 text-lg">
          Sign in to your Nelium Community account
        </p>
        <p class="mt-4 text-center text-sm text-navy-300">
          Don't have an account?
          <RouterLink to="/register" class="font-medium text-primary-400 hover:text-primary-300 transition-colors ml-1">
            Create one here
          </RouterLink>
        </p>
      </div>
      <!-- Login Card -->
      <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 p-8">
        <form class="space-y-6" @submit.prevent="handleLogin">
          <div class="space-y-4">
            <div>
              <label for="email" class="block text-sm font-medium text-white mb-2">Email Address</label>
              <input
                id="email"
                v-model="form.email"
                name="email"
                type="email"
                autocomplete="email"
                required
                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-navy-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                placeholder="Enter your email"
              />
            </div>
            <div>
              <label for="password" class="block text-sm font-medium text-white mb-2">Password</label>
              <input
                id="password"
                v-model="form.password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-navy-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                placeholder="Enter your password"
              />
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember-me"
                name="remember-me"
                type="checkbox"
                class="h-4 w-4 text-primary-500 focus:ring-primary-400 border-white/20 rounded bg-white/10 backdrop-blur-sm"
              />
              <label for="remember-me" class="ml-2 block text-sm text-white">
                Remember me
              </label>
            </div>

            <div class="text-sm">
              <RouterLink to="/forgot-password" class="font-medium text-primary-400 hover:text-primary-300 transition-colors">
                Forgot password?
              </RouterLink>
            </div>
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="group relative w-full flex justify-center items-center py-3 px-6 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ loading ? 'Signing in...' : 'Sign In' }}
          </button>

          <div v-if="error" class="mt-4 p-3 bg-red-500/20 border border-red-400/30 rounded-lg text-red-200 text-sm text-center backdrop-blur-sm">
            {{ error }}
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
  email: '',
  password: ''
})

const loading = ref(false)
const error = ref('')

const handleLogin = async () => {
  loading.value = true
  error.value = ''
  
  try {
    await authStore.login(form.value.email, form.value.password)
    router.push('/portal')
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Login failed'
  } finally {
    loading.value = false
  }
}
</script>
