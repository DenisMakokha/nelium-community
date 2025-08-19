<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h1 class="text-3xl sm:text-4xl font-heading font-semibold text-navy-900">Reports & Analytics</h1>
          <p class="text-navy-600 text-lg">View platform performance and insights</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
          <select v-model="selectedPeriod" @change="loadReports" class="form-input w-full sm:w-auto">
            <option value="7">Last 7 days</option>
            <option value="30">Last 30 days</option>
            <option value="90">Last 90 days</option>
            <option value="365">Last year</option>
          </select>
          <button @click="exportReports" class="w-full sm:w-auto bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export CSV
          </button>
        </div>
      </div>

      <!-- Key Metrics -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-white rounded-lg p-4 sm:p-6 shadow hover:shadow-md transition-shadow duration-200">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-gradient-to-r from-primary-100 to-primary-200">
              <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-navy-600">New Members</p>
              <p class="text-2xl font-semibold text-navy-900">{{ reportsData?.new_members || 0 }}</p>
              <p class="text-xs text-emerald-600">+{{ reportsData?.member_growth_rate || 0 }}% from last period</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg p-4 sm:p-6 shadow hover:shadow-md transition-shadow duration-200">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-gradient-to-r from-emerald-100 to-emerald-200">
              <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-navy-600">Revenue</p>
              <p class="text-2xl font-semibold text-navy-900">{{ formatCurrency(reportsData?.total_revenue || 0) }}</p>
              <p class="text-xs text-emerald-600">+{{ reportsData?.revenue_growth_rate || 0 }}% from last period</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Events Held</p>
              <p class="text-2xl font-semibold text-gray-900">{{ reportsData?.events_count || 0 }}</p>
              <p class="text-xs text-blue-600">{{ reportsData?.avg_attendance || 0 }} avg attendance</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100">
              <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Downloads</p>
              <p class="text-2xl font-semibold text-gray-900">{{ reportsData?.resource_downloads || 0 }}</p>
              <p class="text-xs text-purple-600">{{ reportsData?.popular_resource || 'N/A' }} most popular</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg p-6 shadow">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Membership Growth</h3>
            <span class="text-sm text-gray-500">{{ selectedPeriod }} days</span>
          </div>
          <div class="h-64">
            <div v-if="loading" class="h-full flex items-center justify-center">
              <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blueA"></div>
            </div>
            <div v-else-if="reportsData?.membership_chart?.length" class="h-full">
              <canvas ref="membershipChart" class="w-full h-full"></canvas>
            </div>
            <div v-else class="h-full flex items-center justify-center bg-gray-50 rounded">
              <p class="text-gray-500">No membership data available</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Revenue Trends</h3>
            <span class="text-sm text-gray-500">{{ selectedPeriod }} days</span>
          </div>
          <div class="h-64">
            <div v-if="loading" class="h-full flex items-center justify-center">
              <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blueA"></div>
            </div>
            <div v-else-if="reportsData?.revenue_chart?.length" class="h-full">
              <canvas ref="revenueChart" class="w-full h-full"></canvas>
            </div>
            <div v-else class="h-full flex items-center justify-center bg-gray-50 rounded">
              <p class="text-gray-500">No revenue data available</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Data Tables -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Top Performing Events</h3>
          </div>
          <div class="divide-y divide-gray-200">
            <div v-if="loading" class="p-6 text-center">
              <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blueA mx-auto"></div>
            </div>
            <div v-else-if="!reportsData?.top_events?.length" class="p-6 text-center text-gray-500">
              No events data available
            </div>
            <div v-else v-for="event in reportsData.top_events" :key="event.id" class="px-6 py-4">
              <div class="flex justify-between items-center">
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ event.title }}</p>
                  <p class="text-xs text-gray-500">{{ formatDate(event.date) }}</p>
                </div>
                <div class="text-right">
                  <p class="text-sm font-semibold text-gray-900">{{ event.attendance }} attendees</p>
                  <p class="text-xs text-gray-500">{{ event.rating }}/5 rating</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Popular Resources</h3>
          </div>
          <div class="divide-y divide-gray-200">
            <div v-if="loading" class="p-6 text-center">
              <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blueA mx-auto"></div>
            </div>
            <div v-else-if="!reportsData?.popular_resources?.length" class="p-6 text-center text-gray-500">
              No resources data available
            </div>
            <div v-else v-for="resource in reportsData.popular_resources" :key="resource.id" class="px-6 py-4">
              <div class="flex justify-between items-center">
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ resource.title }}</p>
                  <p class="text-xs text-gray-500">{{ resource.type }}</p>
                </div>
                <div class="text-right">
                  <p class="text-sm font-semibold text-gray-900">{{ resource.downloads }} downloads</p>
                  <p class="text-xs text-gray-500">{{ formatFileSize(resource.size) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'
import { adminService } from '@/services/adminService'

const loading = ref(true)
const reportsData = ref<any>(null)
const selectedPeriod = ref('30')
const membershipChart = ref<HTMLCanvasElement>()
const revenueChart = ref<HTMLCanvasElement>()

const loadReports = async () => {
  try {
    loading.value = true
    reportsData.value = await adminService.getReports({ period: selectedPeriod.value })
    
    // Wait for DOM update before rendering charts
    await nextTick()
    renderCharts()
  } catch (error) {
    console.error('Failed to load reports:', error)
  } finally {
    loading.value = false
  }
}

const renderCharts = () => {
  // Simple chart rendering without external libraries
  if (membershipChart.value && reportsData.value?.membership_chart) {
    renderLineChart(membershipChart.value, reportsData.value.membership_chart, '#3B82F6')
  }
  
  if (revenueChart.value && reportsData.value?.revenue_chart) {
    renderLineChart(revenueChart.value, reportsData.value.revenue_chart, '#10B981')
  }
}

const renderLineChart = (canvas: HTMLCanvasElement, data: any[], color: string) => {
  const ctx = canvas.getContext('2d')
  if (!ctx || !data.length) return

  const { width, height } = canvas
  canvas.width = width
  canvas.height = height

  // Clear canvas
  ctx.clearRect(0, 0, width, height)
  
  // Set up chart area
  const padding = 40
  const chartWidth = width - padding * 2
  const chartHeight = height - padding * 2
  
  // Find min/max values
  const values = data.map(d => d.value)
  const minValue = Math.min(...values)
  const maxValue = Math.max(...values)
  const valueRange = maxValue - minValue || 1
  
  // Draw grid lines
  ctx.strokeStyle = '#E5E7EB'
  ctx.lineWidth = 1
  
  for (let i = 0; i <= 4; i++) {
    const y = padding + (chartHeight / 4) * i
    ctx.beginPath()
    ctx.moveTo(padding, y)
    ctx.lineTo(width - padding, y)
    ctx.stroke()
  }
  
  // Draw line
  ctx.strokeStyle = color
  ctx.lineWidth = 2
  ctx.beginPath()
  
  data.forEach((point, index) => {
    const x = padding + (chartWidth / (data.length - 1)) * index
    const y = padding + chartHeight - ((point.value - minValue) / valueRange) * chartHeight
    
    if (index === 0) {
      ctx.moveTo(x, y)
    } else {
      ctx.lineTo(x, y)
    }
  })
  
  ctx.stroke()
  
  // Draw points
  ctx.fillStyle = color
  data.forEach((point, index) => {
    const x = padding + (chartWidth / (data.length - 1)) * index
    const y = padding + chartHeight - ((point.value - minValue) / valueRange) * chartHeight
    
    ctx.beginPath()
    ctx.arc(x, y, 4, 0, 2 * Math.PI)
    ctx.fill()
  })
}

const exportReports = () => {
  // TODO: Implement CSV export functionality
  console.log('Export reports for period:', selectedPeriod.value)
  alert('Export functionality will be implemented soon')
}

const formatCurrency = (cents: number) => {
  return new Intl.NumberFormat('en-KE', {
    style: 'currency',
    currency: 'KES',
    minimumFractionDigits: 0
  }).format(cents / 100)
}

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const formatFileSize = (bytes: number) => {
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  if (bytes === 0) return '0 Bytes'
  const i = Math.floor(Math.log(bytes) / Math.log(1024))
  return Math.round(bytes / Math.pow(1024, i) * 100) / 100 + ' ' + sizes[i]
}

onMounted(() => {
  loadReports()
})
</script>

<style scoped>
.form-input {
  @apply px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blueA focus:border-blueA;
}

.btn {
  @apply px-4 py-2 rounded-md font-medium transition-colors;
}

canvas {
  max-width: 100%;
  height: auto;
}
</style>
