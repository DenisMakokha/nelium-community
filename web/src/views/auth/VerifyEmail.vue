<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div class="text-center">
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
          Verify Your Email
        </h2>
        <p class="mt-2 text-sm text-gray-600">
          Please check your email and click the verification link to activate your account.
        </p>
      </div>
      
      <div v-if="success" class="text-green-600 text-sm text-center">
        {{ success }}
      </div>
      
      <div v-if="error" class="text-red-600 text-sm text-center">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const success = ref('')
const error = ref('')

onMounted(async () => {
  const token = route.query.token as string
  if (token) {
    try {
      await authStore.verifyEmail(token)
      success.value = 'Email verified successfully! You can now access all features.'
      setTimeout(() => {
        router.push('/portal')
      }, 2000)
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Verification failed'
    }
  }
})
</script>
