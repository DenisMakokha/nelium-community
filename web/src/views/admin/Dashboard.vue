<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header Section -->
      <div class="mb-8 animate-fade-in">
        <h1 class="text-4xl font-heading font-semibold text-navy-900 mb-2">Admin Dashboard</h1>
        <p class="text-navy-600 text-lg">Manage your community platform with data-driven insights</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-20 animate-fade-in">
        <div class="text-center">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-primary-200 border-t-primary-500"></div>
          <p class="text-navy-600 mt-4 text-lg">Loading dashboard insights...</p>
        </div>
      </div>

      <div v-else class="space-y-8">
        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 animate-slide-up">
          <!-- Total Members Card -->
          <div class="group bg-white rounded-xl p-4 sm:p-6 shadow-metric hover:shadow-metric-hover transition-all duration-200 hover:scale-105 border border-gray-100">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs sm:text-sm font-medium text-navy-600 mb-1">Total Members</p>
                    <p class="text-2xl sm:text-3xl font-heading font-semibold text-navy-900">{{ stats?.total_members || 0 }}</p>
                  </div>
                </div>
              </div>
              <div class="w-2 h-2 bg-primary-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
          </div>

          <!-- Monthly Revenue Card -->
          <div class="group bg-white rounded-xl p-6 shadow-metric hover:shadow-metric-hover transition-all duration-200 hover:scale-105 border border-gray-100">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-navy-600 mb-1">Monthly Revenue</p>
                    <p class="text-3xl font-heading font-semibold text-navy-900">{{ formatCurrency(stats?.monthly_revenue || 0) }}</p>
                  </div>
                </div>
              </div>
              <div class="w-2 h-2 bg-emerald-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
          </div>

          <!-- Active Subscriptions Card -->
          <div class="group bg-white rounded-xl p-6 shadow-metric hover:shadow-metric-hover transition-all duration-200 hover:scale-105 border border-gray-100">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <div class="w-12 h-12 bg-gradient-to-r from-aqua-500 to-aqua-600 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-navy-600 mb-1">Active Subscriptions</p>
                    <p class="text-3xl font-heading font-semibold text-navy-900">{{ stats?.active_subscriptions || 0 }}</p>
                  </div>
                </div>
              </div>
              <div class="w-2 h-2 bg-aqua-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
          </div>

          <!-- Total Revenue Card -->
          <div class="group bg-white rounded-xl p-6 shadow-metric hover:shadow-metric-hover transition-all duration-200 hover:scale-105 border border-gray-100">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <div class="w-12 h-12 bg-gradient-to-r from-gold-400 to-gold-500 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-navy-600 mb-1">Total Revenue</p>
                    <p class="text-3xl font-heading font-semibold text-navy-900">{{ formatCurrency(stats?.total_revenue || 0) }}</p>
                  </div>
                </div>
              </div>
              <div class="w-2 h-2 bg-gold-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
          </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-up">
          <!-- Recent Members Card -->
          <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all duration-200 border border-gray-100">
            <div class="p-6 border-b border-gray-100">
              <div class="flex items-center justify-between">
                <h3 class="text-xl font-heading font-semibold text-navy-900">Recent Members</h3>
                <div class="w-3 h-3 bg-primary-500 rounded-full"></div>
              </div>
              <p class="text-navy-600 text-sm mt-1">Latest community members</p>
            </div>
            <div class="p-6">
              <div class="space-y-4">
                <div v-for="member in stats?.recent_members" :key="member.id" 
                     class="group flex items-center justify-between p-3 rounded-lg hover:bg-navy-50 transition-colors duration-150">
                  <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white text-sm font-medium shadow-sm">
                      {{ getInitials(member.name) }}
                    </div>
                    <div>
                      <p class="text-sm font-medium text-navy-900">{{ member.name }}</p>
                      <p class="text-xs text-navy-500">{{ formatDate(member.created_at) }}</p>
                    </div>
                  </div>
                  <RouterLink :to="`/admin/members?search=${member.email}`" 
                             class="text-primary-600 hover:text-primary-700 text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                    View
                  </RouterLink>
                </div>
                <div v-if="!stats?.recent_members?.length" class="text-center py-8">
                  <div class="w-12 h-12 bg-navy-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                  </div>
                  <p class="text-navy-500 text-sm">No recent members</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Payments Card -->
          <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all duration-200 border border-gray-100">
            <div class="p-6 border-b border-gray-100">
              <div class="flex items-center justify-between">
                <h3 class="text-xl font-heading font-semibold text-navy-900">Recent Payments</h3>
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
              </div>
              <p class="text-navy-600 text-sm mt-1">Latest transactions</p>
            </div>
            <div class="p-6">
              <div class="space-y-4">
                <div v-for="payment in stats?.recent_payments" :key="payment.id" 
                     class="group flex items-center justify-between p-3 rounded-lg hover:bg-navy-50 transition-colors duration-150">
                  <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-sm font-medium shadow-sm">
                      {{ getInitials(payment.user.name) }}
                    </div>
                    <div>
                      <p class="text-sm font-medium text-navy-900">{{ payment.user.name }}</p>
                      <p class="text-xs text-navy-500">{{ formatCurrency(payment.amount_cents) }} • {{ payment.subscription?.plan?.name }}</p>
                    </div>
                  </div>
                  <span :class="getStatusClass(payment.status)" class="px-3 py-1 text-xs font-medium rounded-full">
                    {{ payment.status }}
                  </span>
                </div>
                <div v-if="!stats?.recent_payments?.length" class="text-center py-8">
                  <div class="w-12 h-12 bg-navy-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                  </div>
                  <p class="text-navy-500 text-sm">No recent payments</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="bg-white rounded-xl shadow-card border border-gray-100 animate-slide-up">
          <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-heading font-semibold text-navy-900">Quick Actions</h3>
            <p class="text-navy-600 text-sm mt-1">Manage your platform efficiently</p>
          </div>
          <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
              <RouterLink to="/admin/members" 
                         class="group flex items-center justify-center p-4 bg-gradient-to-r from-primary-50 to-primary-100 hover:from-primary-100 hover:to-primary-200 rounded-xl transition-all duration-200 hover:scale-105 border border-primary-200">
                <div class="text-center">
                  <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-primary-700">Manage Members</span>
                </div>
              </RouterLink>

              <RouterLink to="/admin/payments" 
                         class="group flex items-center justify-center p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 hover:from-emerald-100 hover:to-emerald-200 rounded-xl transition-all duration-200 hover:scale-105 border border-emerald-200">
                <div class="text-center">
                  <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-emerald-700">View Payments</span>
                </div>
              </RouterLink>

              <RouterLink to="/admin/reports" 
                         class="group flex items-center justify-center p-4 bg-gradient-to-r from-aqua-50 to-aqua-100 hover:from-aqua-100 hover:to-aqua-200 rounded-xl transition-all duration-200 hover:scale-105 border border-aqua-200">
                <div class="text-center">
                  <div class="w-8 h-8 bg-aqua-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-aqua-700">View Reports</span>
                </div>
              </RouterLink>

              <RouterLink to="/admin/announcements" 
                         class="group flex items-center justify-center p-4 bg-gradient-to-r from-gold-50 to-gold-100 hover:from-gold-100 hover:to-gold-200 rounded-xl transition-all duration-200 hover:scale-105 border border-gold-200">
                <div class="text-center">
                  <div class="w-8 h-8 bg-gold-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-gold-700">Announcements</span>
                </div>
              </RouterLink>
            </div>
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
