<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Member Directory</h1>
        <p class="text-gray-600">Connect with fellow community members</p>
      </div>

      <!-- Search and Filter -->
      <div class="mb-6 flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
        <input v-model="filters.search" @input="debouncedSearch" type="search" placeholder="Search members..." class="form-input flex-1 w-full sm:max-w-md">
        <select v-model="filters.country" @change="loadMembers" class="form-input w-full sm:w-auto">
          <option value="">All Countries</option>
          <option value="Kenya">Kenya</option>
          <option value="Nigeria">Nigeria</option>
          <option value="South Africa">South Africa</option>
        </select>
        <select v-model="filters.profession" @change="loadMembers" class="form-input w-full sm:w-auto">
          <option value="">All Industries</option>
          <option value="Technology">Technology</option>
          <option value="Finance">Finance</option>
          <option value="Healthcare">Healthcare</option>
        </select>
      </div>

      <!-- Members Grid -->
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
        <p class="text-navy-600 mt-4">Loading members...</p>
      </div>
      
      <div v-else-if="error" class="text-center py-12">
        <p class="text-red-600 mb-4">{{ error }}</p>
        <button @click="loadMembers" class="text-primary-600 hover:text-primary-700">Try again</button>
      </div>
      
      <div v-else-if="members.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <div v-for="member in members" :key="member.id" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-lg hover:border-primary-200 transition-all duration-300 group">
          <div :class="[
            'w-16 h-16 rounded-full flex items-center justify-center text-white text-lg font-bold mx-auto mb-4 group-hover:scale-105 transition-transform',
            getAvatarGradient(member.id)
          ]">
            {{ getInitials(member.name) }}
          </div>
          <h3 class="font-semibold text-navy-900 mb-1">{{ member.name }}</h3>
          <p class="text-sm text-navy-600 mb-2">{{ member.profession || 'Community Member' }}</p>
          <p v-if="member.country" class="text-xs text-navy-500 mb-4 flex items-center justify-center">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ member.country }}
          </p>
          <button class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
            Connect
          </button>
        </div>
      </div>
      
      <div v-else class="text-center py-12">
        <p class="text-navy-600">No members found</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { debounce } from 'lodash'
import { portalService, type Member } from '@/services/portalService'

const members = ref<Member[]>([])
const loading = ref(true)
const error = ref('')
const filters = ref({
  search: '',
  country: '',
  profession: ''
})

const loadMembers = async () => {
  try {
    loading.value = true
    error.value = ''
    const response = await portalService.getMembers(filters.value)
    members.value = response.data || []
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Failed to load members'
    console.error('Members error:', err)
  } finally {
    loading.value = false
  }
}

const debouncedSearch = debounce(() => {
  loadMembers()
}, 300)

const getInitials = (name: string) => {
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
}

const getAvatarGradient = (id: number) => {
  const gradients = [
    'bg-gradient-to-r from-primary-500 to-primary-600',
    'bg-gradient-to-r from-emerald-500 to-emerald-600',
    'bg-gradient-to-r from-gold-500 to-gold-600',
    'bg-gradient-to-r from-navy-500 to-navy-600',
    'bg-gradient-to-r from-purple-500 to-purple-600'
  ]
  return gradients[id % gradients.length]
}

onMounted(() => {
  loadMembers()
})
</script>
