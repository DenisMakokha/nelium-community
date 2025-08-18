<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Payments</h1>
        <p class="text-blue-200">Monitor payment transactions ({{ paymentsData?.total || 0 }} total)</p>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg p-6 shadow mb-6">
        <div class="flex flex-wrap gap-4">
          <select v-model="filters.status" @change="loadPayments" class="form-input w-auto">
            <option value="all">All Status</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
          </select>
          <input v-model="filters.from" @change="loadPayments" type="date" class="form-input w-auto" placeholder="From date">
          <input v-model="filters.to" @change="loadPayments" type="date" class="form-input w-auto" placeholder="To date">
          <button @click="exportPayments" class="btn bg-blueA text-white hover:bg-blue-700">Export CSV</button>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="bg-white rounded-lg p-8 shadow text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blueA"></div>
        <p class="text-gray-600 mt-2">Loading payments...</p>
      </div>

      <!-- Payments Table -->
      <div v-else class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transaction</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="payment in paymentsData?.data" :key="payment.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">#{{ payment.id }}</div>
                <div class="text-sm text-gray-500">{{ payment.subscription?.plan?.name || 'N/A' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ payment.user.name }}</div>
                <div class="text-sm text-gray-500">{{ payment.user.email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ formatCurrency(payment.amount_cents) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(payment.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                  {{ payment.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(payment.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button @click="viewPayment(payment)" class="text-blueA hover:underline mr-3">View</button>
                <button v-if="payment.status === 'completed'" @click="refundPayment(payment)" class="text-red-600 hover:underline">Refund</button>
              </td>
            </tr>
            <tr v-if="!paymentsData?.data?.length">
              <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                No payments found
              </td>
            </tr>
          </tbody>
        </table>
        
        <!-- Pagination -->
        <div v-if="paymentsData?.last_page > 1" class="bg-gray-50 px-6 py-3 flex items-center justify-between">
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

const getStatusClass = (status: string) => {
  switch (status?.toLowerCase()) {
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

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
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
