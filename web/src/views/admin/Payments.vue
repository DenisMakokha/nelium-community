<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h1 class="text-3xl sm:text-4xl font-heading font-semibold text-navy-900">Payments</h1>
          <p class="text-navy-600 text-lg">Monitor payment transactions ({{ paymentsData?.total || 0 }} total)</p>
        </div>
        <button @click="exportPayments" class="w-full sm:w-auto bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
          <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          Export CSV
        </button>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg p-4 sm:p-6 shadow mb-6">
        <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
          <select v-model="filters.status" @change="loadPayments" class="form-input w-full sm:w-auto">
            <option value="all">All Status</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
          </select>
          <input v-model="filters.from" @change="loadPayments" type="date" class="form-input w-full sm:w-auto" placeholder="From date">
          <input v-model="filters.to" @change="loadPayments" type="date" class="form-input w-full sm:w-auto" placeholder="To date">
          <button @click="exportPayments" class="btn bg-blueA text-white hover:bg-blue-700 w-full sm:w-auto">Export CSV</button>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="bg-white rounded-lg p-8 shadow text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blueA"></div>
        <p class="text-gray-600 mt-2">Loading payments...</p>
      </div>

      <!-- Payments Table -->
      <div v-else class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Mobile Card View (hidden on larger screens) -->
        <div class="block sm:hidden">
          <template v-if="loading">
            <div v-for="i in 3" :key="i" class="p-4 border-b border-gray-100 animate-pulse">
              <div class="flex items-center justify-between mb-3">
                <div class="w-20 h-4 bg-gray-200 rounded"></div>
                <div class="w-16 h-6 bg-gray-200 rounded-full"></div>
              </div>
              <div class="space-y-2">
                <div class="w-32 h-4 bg-gray-200 rounded"></div>
                <div class="w-24 h-3 bg-gray-200 rounded"></div>
                <div class="w-28 h-3 bg-gray-200 rounded"></div>
              </div>
            </div>
          </template>
          <template v-else>
            <div v-for="payment in paymentsData?.data" :key="payment.id" class="p-4 border-b border-gray-100 hover:bg-gray-50">
              <div class="flex items-center justify-between mb-3">
                <div class="flex items-center space-x-2">
                  <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-emerald-500 to-emerald-600 text-white flex items-center justify-center text-xs font-semibold">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-semibold text-navy-900">#{{ payment.id }}</span>
                </div>
                <span :class="getStatusClass(payment.status)" class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full">
                  <div class="w-1.5 h-1.5 rounded-full mr-1" :class="getStatusDotClass(payment.status)"></div>
                  {{ payment.status }}
                </span>
              </div>
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-sm text-navy-600">Amount</span>
                  <span class="text-sm font-semibold text-navy-900">{{ formatCurrency(payment.amount_cents) }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-navy-600">Member</span>
                  <span class="text-sm text-navy-900">{{ payment.user.name }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-navy-600">Date</span>
                  <span class="text-sm text-navy-900">{{ formatDate(payment.created_at) }}</span>
                </div>
                <div class="flex justify-end space-x-2 mt-3">
                  <button @click="viewPayment(payment)" 
                          class="inline-flex items-center px-3 py-1 text-xs text-primary-600 hover:text-primary-700 hover:bg-primary-50 rounded-md transition-colors">
                    View
                  </button>
                  <button v-if="payment.status === 'completed'" 
                          @click="refundPayment(payment)" 
                          class="inline-flex items-center px-3 py-1 text-xs text-red-600 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors">
                    Refund
                  </button>
                </div>
              </div>
            </div>
          </template>
        </div>

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden sm:block overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gradient-to-r from-navy-50 to-primary-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Transaction</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Member</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Amount</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Date</th>
              <th class="px-6 py-4 text-right text-xs font-semibold text-navy-700 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            <!-- Loading Skeleton -->
            <template v-if="loading">
              <SkeletonLoader v-for="i in 5" :key="i" type="payment-row" />
            </template>
            
            <!-- Actual Data -->
            <template v-else>
              <tr v-for="(payment, index) in paymentsData?.data" :key="payment.id" 
                  :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'" 
                  class="hover:bg-primary-50 transition-colors duration-150 group">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 text-white flex items-center justify-center text-xs font-semibold shadow-sm group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                  </div>
                  <div class="ml-3">
                    <div class="text-sm font-semibold text-navy-900 group-hover:text-primary-700 transition-colors">#{{ payment.id }}</div>
                    <div class="text-sm text-navy-500">{{ payment.subscription?.plan?.name || 'N/A' }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="h-9 w-9 rounded-lg bg-gradient-to-r from-primary-500 to-primary-600 text-white flex items-center justify-center text-xs font-semibold shadow-sm">
                    {{ getInitials(payment.user.name) }}
                  </div>
                  <div class="ml-3">
                    <div class="text-sm font-semibold text-navy-900">{{ payment.user.name }}</div>
                    <div class="text-sm text-navy-500">{{ payment.user.email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-lg font-bold text-navy-900">{{ formatCurrency(payment.amount_cents) }}</div>
                <div class="text-xs text-navy-500">{{ payment.currency || 'USD' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(payment.status)" class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full">
                  <div class="w-2 h-2 rounded-full mr-2" :class="getStatusDotClass(payment.status)"></div>
                  {{ payment.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-navy-700 font-medium">{{ formatDate(payment.created_at) }}</div>
                <div class="text-xs text-navy-500">{{ getRelativeTime(payment.created_at) }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right">
                <div class="flex items-center justify-end space-x-2">
                  <button @click="viewPayment(payment)" 
                          class="inline-flex items-center p-2 text-primary-600 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-all duration-200 hover:scale-105"
                          title="View Payment Details">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                  </button>
                  <button v-if="payment.status === 'completed'" 
                          @click="refundPayment(payment)" 
                          class="inline-flex items-center p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 hover:scale-105"
                          title="Process Refund">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            </template>
            <template v-if="!loading && !paymentsData?.data?.length">
              <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-navy-100 rounded-full flex items-center justify-center mb-4">
                      <svg class="w-8 h-8 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                      </svg>
                    </div>
                    <p class="text-navy-500 text-lg font-medium">No payments found</p>
                    <p class="text-navy-400 text-sm">Payments will appear here once members make transactions</p>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
          </table>
        </div>
        
        <!-- Pagination -->
        <div v-if="paymentsData?.last_page > 1" class="bg-gray-50 px-4 sm:px-6 py-3 flex flex-col sm:flex-row items-center justify-between gap-3">
          <div class="text-sm text-gray-700">
            Showing {{ paymentsData.from }} to {{ paymentsData.to }} of {{ paymentsData.total }} results
          </div>
          <div class="flex space-x-2">
            <button 
              @click="changePage(paymentsData.current_page - 1)"
              :disabled="paymentsData.current_page === 1"
              class="btn btn-outline btn-sm"
            >
              Previous
            </button>
            <button 
              @click="changePage(paymentsData.current_page + 1)"
              :disabled="paymentsData.current_page === paymentsData.last_page"
              class="btn btn-outline btn-sm"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue'
import { adminService, type Payment } from '@/services/adminService'
import SkeletonLoader from '@/components/SkeletonLoader.vue'

const loading = ref(true)
const paymentsData = ref<any>(null)

const filters = reactive({
  status: 'all',
  from: '',
  to: '',
  page: 1
})

const loadPayments = async () => {
  try {
    loading.value = true
    const params = {
      status: filters.status !== 'all' ? filters.status : undefined,
      from: filters.from || undefined,
      to: filters.to || undefined,
      page: filters.page
    }
    paymentsData.value = await adminService.getPayments(params)
  } catch (error) {
    console.error('Failed to load payments:', error)
  } finally {
    loading.value = false
  }
}

const changePage = (page: number) => {
  filters.page = page
  loadPayments()
}

const viewPayment = (payment: Payment) => {
  // TODO: Implement payment detail modal
  console.log('View payment:', payment)
}

const refundPayment = async (payment: Payment) => {
  if (confirm(`Are you sure you want to refund ${formatCurrency(payment.amount_cents)}?`)) {
    // TODO: Implement refund functionality
    console.log('Refund payment:', payment)
    alert('Refund functionality not implemented yet')
  }
}

const exportPayments = () => {
  // TODO: Implement CSV export
  console.log('Export payments')
  alert('Export functionality not implemented yet')
}

const formatCurrency = (cents: number) => {
  return new Intl.NumberFormat('en-KE', {
    style: 'currency',
    currency: 'KES',
    minimumFractionDigits: 0
  }).format(cents / 100)
}

const getInitials = (name: string) => {
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
}

const getStatusClass = (status: string) => {
  switch (status?.toLowerCase()) {
    case 'completed':
    case 'paid':
      return 'bg-emerald-100 text-emerald-800 border border-emerald-200'
    case 'pending':
      return 'bg-amber-100 text-amber-800 border border-amber-200'
    case 'failed':
      return 'bg-red-100 text-red-800 border border-red-200'
    default:
      return 'bg-gray-100 text-gray-800 border border-gray-200'
  }
}

const getStatusDotClass = (status: string) => {
  switch (status?.toLowerCase()) {
    case 'completed':
    case 'paid':
      return 'bg-emerald-500'
    case 'pending':
      return 'bg-amber-500'
    case 'failed':
      return 'bg-red-500'
    default:
      return 'bg-gray-500'
  }
}

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const getRelativeTime = (dateString: string) => {
  const date = new Date(dateString)
  const now = new Date()
  const diffTime = Math.abs(now.getTime() - date.getTime())
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  
  if (diffDays === 1) return '1 day ago'
  if (diffDays < 30) return `${diffDays} days ago`
  if (diffDays < 365) return `${Math.floor(diffDays / 30)} months ago`
  return `${Math.floor(diffDays / 365)} years ago`
}

onMounted(() => {
  loadPayments()
})
</script>

<style scoped>
.form-input {
  @apply px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blueA focus:border-blueA;
}

.btn {
  @apply px-4 py-2 rounded-md font-medium transition-colors;
}

.btn-outline {
  @apply border border-gray-300 text-gray-700 hover:bg-gray-50;
}

.btn-sm {
  @apply px-3 py-1 text-sm;
}

.btn:disabled {
  @apply opacity-50 cursor-not-allowed;
}
</style>
