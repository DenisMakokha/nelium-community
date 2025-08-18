<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Create your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Or
          <RouterLink to="/login" class="font-medium text-blueA hover:text-blue-500">
            sign in to existing account
          </RouterLink>
        </p>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
        <div class="space-y-4">
          <div>
            <label for="name" class="form-label">Full Name</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="form-input"
              placeholder="Enter your full name"
            />
          </div>
          <div>
            <label for="email" class="form-label">Email Address</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="form-input"
              placeholder="Enter your email"
            />
          </div>
          <div>
            <label for="org" class="form-label">Organization (Optional)</label>
            <input
              id="org"
              v-model="form.org"
              type="text"
              class="form-input"
              placeholder="Your organization"
            />
          </div>
          <div>
            <label for="country" class="form-label">Country (Optional)</label>
            <input
              id="country"
              v-model="form.country"
              type="text"
              class="form-input"
              placeholder="Your country"
            />
          </div>
          <div>
            <label for="password" class="form-label">Password</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="form-input"
              placeholder="Create a password"
            />
          </div>
          <div>
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              required
              class="form-input"
              placeholder="Confirm your password"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blueA hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blueA disabled:opacity-50"
          >
            {{ loading ? 'Creating account...' : 'Create Account' }}
          </button>
        </div>

        <div v-if="error" class="text-red-600 text-sm text-center">
          {{ error }}
        </div>
        
        <div v-if="success" class="text-green-600 text-sm text-center">
          {{ success }}
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const form = ref({
  name: '',
  email: '',
  org: '',
  country: '',
  password: '',
  password_confirmation: ''
})

const loading = ref(false)
const error = ref('')
const success = ref('')

const handleRegister = async () => {
  loading.value = true
  error.value = ''
  success.value = ''
  
  try {
    await authStore.register(form.value)
    success.value = 'Account created successfully! Please check your email to verify your account.'
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Registration failed'
  } finally {
    loading.value = false
  }
}
</script>
