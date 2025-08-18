<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
        <p class="text-blue-200">Manage your community platform</p>
      </div>

      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
        <p class="text-blue-200 mt-2">Loading dashboard...</p>
      </div>

      <div v-else>
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="bg-white rounded-lg p-6 shadow">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blueA rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Members</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats?.total_members || 0 }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg p-6 shadow">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                <p class="text-2xl font-semibold text-gray-900">{{ formatCurrency(stats?.monthly_revenue || 0) }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg p-6 shadow">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blueB rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Active Subscriptions</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats?.active_subscriptions || 0 }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg p-6 shadow">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-aqua rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                <p class="text-2xl font-semibold text-gray-900">{{ formatCurrency(stats?.total_revenue || 0) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <div class="bg-white rounded-lg p-6 shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Members</h3>
            <div class="space-y-3">
              <div v-for="member in stats?.recent_members" :key="member.id" class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="w-8 h-8 rounded-full bg-blueA flex items-center justify-center text-white text-xs font-medium">
                    {{ getInitials(member.name) }}
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ member.name }}</p>
                    <p class="text-xs text-gray-500">{{ formatDate(member.created_at) }}</p>
                  </div>
                </div>
                <RouterLink :to="`/admin/members?search=${member.email}`" class="text-blueA hover:underline text-sm">View</RouterLink>
              </div>
              <div v-if="!stats?.recent_members?.length" class="text-gray-500 text-sm text-center py-4">
                No recent members
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg p-6 shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Payments</h3>
            <div class="space-y-3">
              <div v-for="payment in stats?.recent_payments" :key="payment.id" class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-medium">
                    {{ getInitials(payment.user.name) }}
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ payment.user.name }}</p>
                    <p class="text-xs text-gray-500">{{ formatCurrency(payment.amount_cents) }} - {{ payment.subscription?.plan?.name }}</p>
                  </div>
                </div>
                <span :class="getStatusClass(payment.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                  {{ payment.status }}
                </span>
              </div>
              <div v-if="!stats?.recent_payments?.length" class="text-gray-500 text-sm text-center py-4">
                No recent payments
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg p-6 shadow mt-8">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <RouterLink to="/admin/members" class="btn btn-outline text-center">Manage Members</RouterLink>
            <RouterLink to="/admin/payments" class="btn btn-outline text-center">View Payments</RouterLink>
            <RouterLink to="/admin/reports" class="btn btn-outline text-center">View Reports</RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { adminService, type DashboardStats } from '@/services/adminService'

const loading = ref(true)
const stats = ref<DashboardStats | null>(null)

const loadDashboard = async () => {
  try {
    loading.value = true
    stats.value = await adminService.getDashboardStats()
  } catch (error) {
    console.error('Failed to load dashboard:', error)
  } finally {
    loading.value = false
  }
}

const formatCurrency = (cents: number) => {
  return new Intl.NumberFormat('en-KE', {
    style: 'currency',
    currency: 'KES',
    minimumFractionDigits: 0
  }).format(cents / 100)
}

const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  const now = new Date()
  const diffTime = Math.abs(now.getTime() - date.getTime())
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  
  if (diffDays === 1) return 'Yesterday'
  if (diffDays < 7) return `${diffDays} days ago`
  return date.toLocaleDateString()
}

const getInitials = (name: string) => {
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
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

onMounted(() => {
  loadDashboard()
})
</script>
