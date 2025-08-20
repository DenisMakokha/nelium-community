<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-heading font-semibold text-navy-900">Resource Library</h1>
        <p class="text-navy-600 text-lg">Access exclusive resources for community members</p>
      </div>

      <!-- Filter Bar -->
      <div class="mb-6 flex flex-wrap gap-4">
        <select v-model="filters.category" @change="loadResources" class="form-input w-auto">
          <option value="">All Categories</option>
          <option value="business">Business</option>
          <option value="technology">Technology</option>
          <option value="finance">Finance</option>
          <option value="legal">Legal</option>
        </select>
        <select v-model="filters.type" @change="loadResources" class="form-input w-auto">
          <option value="">All Types</option>
          <option value="document">Document</option>
          <option value="video">Video</option>
          <option value="link">Link</option>
        </select>
        <input v-model="filters.search" @input="debouncedSearch" type="search" placeholder="Search resources..." class="form-input flex-1 max-w-md">
      </div>

      <!-- Resources Grid -->
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
        <p class="text-navy-600 mt-4">Loading resources...</p>
      </div>
      
      <div v-else-if="error" class="text-center py-12">
        <p class="text-red-600 mb-4">{{ error }}</p>
        <button @click="loadResources" class="text-primary-600 hover:text-primary-700">Try again</button>
      </div>
      
      <div v-else-if="resources.length" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <div v-for="resource in resources" :key="resource.id" 
             class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group hover:scale-105">
          <div class="p-6">
            <div class="flex items-start justify-between mb-4">
              <div :class="[
                'w-14 h-14 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform',
                getResourceIcon(resource.type).gradient
              ]">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getResourceIcon(resource.type).path"></path>
                </svg>
              </div>
              <span :class="[
                'px-3 py-1 text-xs font-medium rounded-full',
                getCategoryClass(resource.category)
              ]">
                {{ resource.category.charAt(0).toUpperCase() + resource.category.slice(1) }}
              </span>
            </div>
            <h3 class="text-xl font-semibold text-navy-900 mb-3 group-hover:text-primary-600 transition-colors">{{ resource.title }}</h3>
            <p class="text-navy-600 mb-4 leading-relaxed line-clamp-3">{{ resource.description }}</p>
            <div class="flex items-center justify-between text-sm text-navy-500 mb-4">
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ new Date(resource.created_at).toLocaleDateString() }}
              </span>
              <span v-if="resource.file_size" class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                {{ formatFileSize(resource.file_size) }}
              </span>
            </div>
            <button @click="handleResourceAction(resource)" 
                    :class="[
                      'w-full py-3 px-4 rounded-lg font-medium transition-all duration-200 hover:shadow-md',
                      getResourceIcon(resource.type).buttonClass
                    ]">
              <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getResourceIcon(resource.type).buttonIcon"></path>
              </svg>
              {{ getResourceIcon(resource.type).buttonText }}
            </button>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-12">
        <p class="text-navy-600">No resources found</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { debounce } from 'lodash'
import { portalService, type Resource } from '@/services/portalService'

const resources = ref<Resource[]>([])
const loading = ref(true)
const error = ref('')
const filters = ref({
  search: '',
  category: '',
  type: ''
})

const loadResources = async () => {
  try {
    loading.value = true
    error.value = ''
    const response = await portalService.getResources(filters.value)
    resources.value = response.data || []
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Failed to load resources'
    console.error('Resources error:', err)
  } finally {
    loading.value = false
  }
}

const debouncedSearch = debounce(() => {
  loadResources()
}, 300)

const getResourceIcon = (type: string) => {
  switch (type) {
    case 'video':
      return {
        gradient: 'bg-gradient-to-r from-emerald-500 to-emerald-600',
        path: 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
        buttonClass: 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white hover:from-emerald-600 hover:to-emerald-700',
        buttonIcon: 'M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1',
        buttonText: 'Watch Now'
      }
    case 'link':
      return {
        gradient: 'bg-gradient-to-r from-gold-500 to-gold-600',
        path: 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14',
        buttonClass: 'bg-gradient-to-r from-gold-500 to-gold-600 text-white hover:from-gold-600 hover:to-gold-700',
        buttonIcon: 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14',
        buttonText: 'Open Link'
      }
    default:
      return {
        gradient: 'bg-gradient-to-r from-primary-500 to-primary-600',
        path: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        buttonClass: 'bg-gradient-to-r from-primary-500 to-primary-600 text-white hover:from-primary-600 hover:to-primary-700',
        buttonIcon: 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        buttonText: 'Download'
      }
  }
}

const getCategoryClass = (category: string) => {
  switch (category) {
    case 'business':
      return 'bg-primary-100 text-primary-700'
    case 'technology':
      return 'bg-emerald-100 text-emerald-700'
    case 'finance':
      return 'bg-gold-100 text-gold-700'
    case 'legal':
      return 'bg-navy-100 text-navy-700'
    default:
      return 'bg-gray-100 text-gray-700'
  }
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const handleResourceAction = async (resource: Resource) => {
  if (resource.type === 'link' && resource.external_url) {
    window.open(resource.external_url, '_blank')
  } else if (resource.file_path) {
    try {
      const response = await portalService.downloadResource(resource.id)
      const url = window.URL.createObjectURL(new Blob([response.data]))
      const link = document.createElement('a')
      link.href = url
      link.download = resource.title
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
      window.URL.revokeObjectURL(url)
    } catch (err) {
      console.error('Download error:', err)
    }
  }
}

onMounted(() => {
  loadResources()
})
</script>
