<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
      <div v-if="loading" class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blueA mx-auto mb-4"></div>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Processing Payment</h2>
        <p class="text-gray-600">Please wait while we verify your payment...</p>
      </div>

      <div v-else-if="success" class="text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Payment Successful!</h2>
        <p class="text-gray-600 mb-6">Your subscription has been activated successfully.</p>
        <RouterLink to="/portal" class="btn btn-primary">Go to Dashboard</RouterLink>
      </div>

      <div v-else class="text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Payment Failed</h2>
        <p class="text-gray-600 mb-6">{{ error || 'There was an issue processing your payment.' }}</p>
        <div class="space-y-3">
          <RouterLink to="/membership" class="btn btn-primary w-full">Try Again</RouterLink>
          <RouterLink to="/portal" class="btn btn-outline w-full">Go to Dashboard</RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import { http } from '@/api/http'

const route = useRoute()
const loading = ref(true)
const success = ref(false)
const error = ref('')

onMounted(async () => {
  const transactionId = route.query.transaction_id as string
  const txRef = route.query.tx_ref as string
  const status = route.query.status as string

  if (!transactionId || !txRef) {
    error.value = 'Invalid payment callback parameters'
    loading.value = false
    return
  }

  if (status === 'cancelled') {
    error.value = 'Payment was cancelled'
    loading.value = false
    return
  }

  try {
    const response = await http.post('/payments/verify', {
      transaction_id: transactionId,
      tx_ref: txRef
    })

    if (response.data.success) {
      success.value = true
    } else {
      error.value = response.data.message || 'Payment verification failed'
    }
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Payment verification failed'
  } finally {
    loading.value = false
  }
})
</script>
