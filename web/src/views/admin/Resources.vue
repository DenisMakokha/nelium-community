<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h1 class="text-3xl sm:text-4xl font-heading font-semibold text-navy-900">Resources</h1>
          <p class="text-navy-600 text-lg">Manage community resources and file uploads</p>
        </div>
        <button @click="openAddModal" class="w-full sm:w-auto bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
          <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Add Resource
        </button>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg p-6 shadow mb-6">
        <div class="flex flex-wrap gap-4">
          <input 
            v-model="filters.search" 
            @input="debouncedSearch"
            type="search" 
            placeholder="Search resources..." 
            class="form-input flex-1 max-w-md"
          >
          <select v-model="filters.category" @change="loadResources" class="form-input w-auto">
            <option value="all">All Categories</option>
            <option value="document">Document</option>
            <option value="template">Template</option>
            <option value="guide">Guide</option>
            <option value="tool">Tool</option>
          </select>
          <select v-model="filters.tier" @change="loadResources" class="form-input w-auto">
            <option value="all">All Tiers</option>
            <option value="FREE">Free</option>
            <option value="IND">Individual</option>
            <option value="INST">Institutional</option>
          </select>
        </div>
      </div>

      <!-- Resources Grid -->
      <div class="bg-white rounded-lg shadow">
        <div v-if="loading" class="flex justify-center items-center py-12">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blueA mx-auto"></div>
          <p class="mt-2 text-gray-600">Loading resources...</p>
        </div>
        
        <div v-if="!loading && resources?.data?.length === 0" class="text-center py-8 text-gray-500">
          No resources found
        </div>

        <div v-if="!loading && resources?.data?.length > 0" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 p-6">
          <div v-for="resource in resources.data" :key="resource.id" class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group hover:scale-105">
            <div class="p-6">
              <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                  <svg v-if="resource.category === 'document'" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                  <svg v-else-if="resource.category === 'template'" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                  </svg>
                  <svg v-else-if="resource.category === 'guide'" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                  </svg>
                  <svg v-else class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                </div>
                <div class="flex items-center space-x-2">
                  <span :class="getCategoryClass(resource.category)" class="px-3 py-1 text-xs font-medium rounded-full">
                    {{ resource.category }}
                  </span>
                  <div class="flex space-x-1">
                    <button @click="editResource(resource)" class="p-2 text-navy-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all duration-200 hover:scale-105" title="Edit Resource">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </button>
                    <button @click="deleteResource(resource)" class="p-2 text-navy-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 hover:scale-105" title="Delete Resource">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <h3 class="text-xl font-semibold text-navy-900 mb-3 group-hover:text-primary-600 transition-colors">{{ resource.title || 'Untitled Resource' }}</h3>
              <p class="text-navy-600 mb-4 leading-relaxed">{{ resource.description ? resource.description.substring(0, 120) + '...' : 'No description available' }}</p>
              <div class="flex items-center justify-between text-sm text-navy-500 mb-4">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                  </svg>
                  {{ getFileInfo(resource) }}
                </span>
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                  </svg>
                  {{ resource.tier_min || 'Any' }} tier
                </span>
              </div>
              <div v-if="resource.tags && resource.tags.trim()" class="flex flex-wrap gap-2 mb-4">
                <span v-for="tag in resource.tags.split(',')" :key="tag" class="text-xs bg-navy-100 text-navy-600 px-2 py-1 rounded-full">
                  {{ tag.trim() }}
                </span>
              </div>
              <div class="flex space-x-2">
                <button @click="viewResource(resource)" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-2 px-4 rounded-lg font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:shadow-md text-sm">
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  View
                </button>
                <button @click="downloadResource(resource)" class="flex-1 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-2 px-4 rounded-lg font-medium hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 hover:shadow-md text-sm">
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                  Download
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="resources?.last_page > 1" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
          <div class="flex-1 flex justify-between sm:hidden">
            <button 
              @click="changePage(resources.current_page - 1)"
              :disabled="resources.current_page <= 1"
              class="btn btn-outline btn-sm"
            >
              Previous
            </button>
            <button 
              @click="changePage(resources.current_page + 1)"
              :disabled="resources.current_page >= resources.last_page"
              class="btn btn-outline btn-sm"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing page {{ resources.current_page }} of {{ resources.last_page }} 
                ({{ resources.total }} total resources)
              </p>
            </div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
              <button 
                @click="changePage(resources.current_page - 1)"
                :disabled="resources.current_page <= 1"
                class="btn btn-outline btn-sm"
              >
                Previous
              </button>
              <button 
                @click="changePage(resources.current_page + 1)"
                :disabled="resources.current_page >= resources.last_page"
                class="btn btn-outline btn-sm"
              >
                Next
              </button>
            </nav>
          </div>
        </div>
      </div>

      <!-- Add/Edit Resource Modal -->
      <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              {{ showEditModal ? 'Edit Resource' : 'Add New Resource' }}
            </h3>
            <form @submit.prevent="showEditModal ? updateResource() : createResource()">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                  <input 
                    v-model="resourceForm.title" 
                    type="text" 
                    required 
                    class="form-input w-full"
                    placeholder="Enter resource title"
                  >
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                  <textarea 
                    v-model="resourceForm.description" 
                    required 
                    rows="3"
                    class="form-input w-full"
                    placeholder="Enter resource description"
                  ></textarea>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                  <select v-model="resourceForm.category" class="form-input w-full">
                    <option value="document">Document</option>
                    <option value="template">Template</option>
                    <option value="guide">Guide</option>
                    <option value="tool">Tool</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Tier</label>
                  <select v-model="resourceForm.tier_min" class="form-input w-full">
                    <option value="FREE">Free</option>
                    <option value="IND">Individual</option>
                    <option value="INST">Institutional</option>
                  </select>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">File</label>
                  <input 
                    ref="fileInput"
                    type="file" 
                    :required="!showEditModal"
                    @change="handleFileChange"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                    class="form-input w-full"
                  >
                  <p class="text-xs text-gray-500 mt-1">
                    Supported formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR (Max: 10MB)
                  </p>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Tags (comma-separated)</label>
                  <input 
                    v-model="resourceForm.tags" 
                    type="text" 
                    class="form-input w-full"
                    placeholder="e.g., business, template, planning"
                  >
                </div>
              </div>
              <div class="flex justify-end space-x-3">
                <button 
                  type="button" 
                  @click="closeModal" 
                  class="btn btn-outline"
                >
                  Cancel
                </button>
                <button 
                  type="submit" 
                  :disabled="formLoading"
                  class="btn bg-blueA text-white hover:bg-blue-700"
                >
                  {{ formLoading ? 'Saving...' : (showEditModal ? 'Update' : 'Create') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { adminService } from '@/services/adminService'
import { debounce } from 'lodash'

interface Resource {
  id: number
  title: string
  slug: string
  description: string
  category: string
  tier_min: string
  file_path: string
  file_name: string
  file_size: number
  file_type: string
  tags?: string
  created_by: number
  created_at: string
  updated_at: string
  creator?: {
    id: number
    name: string
    email: string
  }
}

interface ResourcesResponse {
  data: Resource[]
  current_page: number
  last_page: number
  total: number
  per_page: number
}

// Reactive data
const loading = ref(false)
const formLoading = ref(false)
const resources = ref<ResourcesResponse | null>(null)
const showAddModal = ref(false)
const showEditModal = ref(false)
const editingResource = ref<Resource | null>(null)
const selectedFile = ref<File | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)

// Filters
const filters = ref({
  search: '',
  category: 'all',
  tier: 'all',
  page: 1
})

// Form data
const resourceForm = ref({
  title: '',
  description: '',
  category: 'document',
  tier_min: 'FREE',
  tags: ''
})

// Methods
const loadResources = async () => {
  try {
    loading.value = true
    const params: any = {
      page: filters.value.page
    }
    
    if (filters.value.search) params.search = filters.value.search
    if (filters.value.category !== 'all') params.category = filters.value.category
    if (filters.value.tier !== 'all') params.tier = filters.value.tier
    
    const response = await adminService.getResources(params)
    resources.value = response
  } catch (error) {
    console.error('Error loading resources:', error)
  } finally {
    loading.value = false
  }
}

const debouncedSearch = debounce(() => {
  filters.value.page = 1
  loadResources()
}, 300)

const changePage = (page: number) => {
  filters.value.page = page
  loadResources()
}

const openAddModal = () => {
  resetForm()
  showAddModal.value = true
}

const editResource = (resource: Resource) => {
  editingResource.value = resource
  resourceForm.value = {
    title: resource.title,
    description: resource.description,
    category: resource.category,
    tier_min: resource.tier_min,
    tags: resource.tags || ''
  }
  showEditModal.value = true
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  editingResource.value = null
  resetForm()
}

const resetForm = () => {
  resourceForm.value = {
    title: '',
    description: '',
    category: 'document',
    tier_min: 'FREE',
    tags: ''
  }
  selectedFile.value = null
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    selectedFile.value = target.files[0]
  }
}

const createResource = async () => {
  if (!selectedFile.value) {
    alert('Please select a file')
    return
  }

  try {
    formLoading.value = true
    const formData = new FormData()
    
    formData.append('title', resourceForm.value.title)
    formData.append('description', resourceForm.value.description)
    formData.append('category', resourceForm.value.category)
    formData.append('tier_min', resourceForm.value.tier_min)
    formData.append('file', selectedFile.value)
    if (resourceForm.value.tags) {
      formData.append('tags', resourceForm.value.tags)
    }

    await adminService.createResource(formData)
    closeModal()
    loadResources()
  } catch (error: any) {
    console.error('Error creating resource:', error)
    alert(error.response?.data?.message || 'Error creating resource')
  } finally {
    formLoading.value = false
  }
}

const updateResource = async () => {
  if (!editingResource.value) return

  try {
    formLoading.value = true
    const formData = new FormData()
    
    formData.append('title', resourceForm.value.title)
    formData.append('description', resourceForm.value.description)
    formData.append('category', resourceForm.value.category)
    formData.append('tier_min', resourceForm.value.tier_min)
    if (resourceForm.value.tags) {
      formData.append('tags', resourceForm.value.tags)
    }
    if (selectedFile.value) {
      formData.append('file', selectedFile.value)
    }

    await adminService.updateResource(editingResource.value.id, formData)
    closeModal()
    loadResources()
  } catch (error: any) {
    console.error('Error updating resource:', error)
    alert(error.response?.data?.message || 'Error updating resource')
  } finally {
    formLoading.value = false
  }
}

const deleteResource = async (resource: Resource) => {
  if (!confirm(`Are you sure you want to delete "${resource.title}"? This will also delete the associated file.`)) {
    return
  }

  try {
    await adminService.deleteResource(resource.id)
    loadResources()
  } catch (error: any) {
    console.error('Error deleting resource:', error)
    alert(error.response?.data?.message || 'Error deleting resource')
  }
}

const getCategoryClass = (category: string) => {
  const classes = {
    document: 'bg-blue-100 text-blue-800',
    template: 'bg-green-100 text-green-800',
    guide: 'bg-purple-100 text-purple-800',
    tool: 'bg-orange-100 text-orange-800'
  }
  return classes[category as keyof typeof classes] || 'bg-gray-100 text-gray-800'
}

const getFileInfo = (resource: Resource) => {
  if (!resource.file_name || !resource.file_size) {
    return 'Unknown file'
  }
  const sizeInMB = (resource.file_size / (1024 * 1024)).toFixed(1)
  const extension = resource.file_name.split('.').pop()?.toUpperCase() || 'FILE'
  return `${extension} • ${sizeInMB} MB`
}

const viewResource = async (resource: Resource) => {
  if (!resource.file_path) {
    alert('File path not available')
    return
  }

  try {
    // For documents and PDFs, open in new tab
    if (resource.file_name?.toLowerCase().includes('.pdf') || 
        resource.file_name?.toLowerCase().includes('.doc') ||
        resource.file_name?.toLowerCase().includes('.txt')) {
      const viewUrl = `${import.meta.env.VITE_API_BASE_URL}/storage/${resource.file_path}`
      window.open(viewUrl, '_blank')
    } else {
      // For other files, trigger download
      downloadResource(resource)
    }
  } catch (error: any) {
    console.error('Error viewing resource:', error)
    alert('Error opening resource')
  }
}

const downloadResource = async (resource: Resource) => {
  if (!resource.file_path) {
    alert('File path not available')
    return
  }

  try {
    const downloadUrl = `${import.meta.env.VITE_API_BASE_URL}/storage/${resource.file_path}`
    
    // Create a temporary link element and trigger download
    const link = document.createElement('a')
    link.href = downloadUrl
    link.download = resource.file_name || 'download'
    link.target = '_blank'
    
    // Append to body, click, and remove
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    
    // Optional: Track download analytics
    console.log(`Downloaded resource: ${resource.title}`)
  } catch (error: any) {
    console.error('Error downloading resource:', error)
    alert('Error downloading resource')
  }
}

// Lifecycle
onMounted(() => {
  loadResources()
})
</script>
