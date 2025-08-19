<template>
  <div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-heading font-semibold text-navy-900">Billing & Subscription</h1>
        <p class="text-navy-600 text-lg">Manage your subscription and payment methods</p>
      </div>

      <div class="space-y-8">
        <!-- Subscription Management -->
        <div class="bg-white rounded-lg p-6 shadow mb-6">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Current Subscription</h2>
            <span v-if="authStore.isAdmin" class="px-2 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded-full">
              Admin View
            </span>
          </div>
          <div v-if="subscription" class="flex justify-between items-start">
            <div>
              <h3 class="text-lg font-medium">{{ subscription.plan.name }}</h3>
              <p class="text-gray-600">{{ formatCurrency(subscription.plan.price_cents) }} / {{ subscription.plan.billing_cycle }}</p>
              <p class="text-sm text-gray-500 mt-1">
                Next billing: {{ formatDate(subscription.current_period_end) }}
              </p>
              <p v-if="authStore.isAdmin" class="text-xs text-orange-600 mt-1">
                User ID: {{ authStore.user?.id }} | Subscription ID: {{ subscription.id }}
              </p>
            </div>
            <div class="flex space-x-2">
              <button 
                v-if="subscription.status === 'active'" 
                @click="cancelSubscription"
                class="btn btn-outline text-red-600 border-red-600 hover:bg-red-50"
              >
                Cancel Subscription
              </button>
              <button 
                v-if="authStore.isAdmin" 
                @click="viewAllSubscriptions"
                class="btn btn-outline text-orange-600 border-orange-600 hover:bg-orange-50"
              >
                View All Subscriptions
              </button>
            </div>
          </div>
          <div v-else class="text-gray-500">
            No active subscription
          </div>
        </div>

        <!-- Payment Method -->
        <div class="card">
          <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center mr-3">
                <span class="text-white text-xs font-bold">VISA</span>
              </div>
              <div>
                <p class="font-medium">•••• •••• •••• 4242</p>
                <p class="text-sm text-gray-600">Expires 12/27</p>
              </div>
            </div>
            <button class="btn btn-outline">Update</button>
          </div>
        </div>

        <!-- Billing History -->
        <div class="card">
          <h2 class="text-xl font-semibold mb-4">Billing History</h2>
          <div v-if="loadingHistory" class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blueA mx-auto"></div>
            <p class="mt-2 text-gray-600">Loading payment history...</p>
          </div>
          <div v-else-if="paymentHistory.length === 0" class="text-center py-8 text-gray-500">
            No payment history found
          </div>
          <div v-else class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="payment in paymentHistory" :key="payment.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ formatDate(payment.created_at) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ payment.subscription?.plan?.name || 'Payment' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ payment.currency }} {{ formatPrice(payment.amount_cents / 100) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="getStatusClass(payment.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                      {{ payment.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <button class="text-blueA hover:underline">Download</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import http from '@/api/http'

const currentPlan = ref('Free Plan')
const subscriptionStatus = ref('No active subscription')
const cancelling = ref(false)
const loadingHistory = ref(true)
const paymentHistory = ref<any[]>([])

const cancelSubscription = async () => {
  if (!confirm('Are you sure you want to cancel your subscription?')) return
  
  cancelling.value = true
  try {
    await http.post('/payments/cancel-subscription')
    currentPlan.value = 'Free Plan'
    subscriptionStatus.value = 'Subscription cancelled'
  } catch (error) {
    console.error('Failed to cancel subscription:', error)
  } finally {
    cancelling.value = false
  }
}

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const formatPrice = (amount: number) => {
  return new Intl.NumberFormat('en-KE').format(amount)
}

const viewAllSubscriptions = () => {
  router.push('/admin/payments')
}

const getStatusClass = (status: string) => {
  switch (status.toLowerCase()) {
    case 'completed':
    case 'paid':
      return 'bg-green-100 text-green-800'
    case 'pending':
      return 'bg-yellow-100 text-yellow-800'
    case 'failed':
      return 'bg-red-100 text-red-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const fetchPaymentHistory = async () => {
  try {
    loadingHistory.value = true
    const response = await http.get('/payments/history')
    if (response.data.success) {
      paymentHistory.value = response.data.payments.data || []
    }
  } catch (error) {
    console.error('Failed to fetch payment history:', error)
  } finally {
    loadingHistory.value = false
  }
}

onMounted(() => {
  // In a real app, fetch subscription data from API
  // For now, using mock data
  fetchPaymentHistory()
})
</script>
