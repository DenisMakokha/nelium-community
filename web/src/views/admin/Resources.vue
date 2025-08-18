<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-white">Resources</h1>
          <p class="text-blue-200">Manage community resources and file uploads</p>
        </div>
        <button @click="openAddModal" class="btn bg-white text-navy hover:bg-gray-100">Add Resource</button>
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

        <div v-if="!loading && resources?.data?.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
          <div v-for="resource in resources.data" :key="resource.id" class="bg-white border rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
              <span :class="getCategoryClass(resource.category)" class="text-xs px-2 py-1 rounded-full">
                {{ resource.category }}
              </span>
              <div class="flex space-x-2">
                <button @click="editResource(resource)" class="text-gray-400 hover:text-gray-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </button>
                <button @click="deleteResource(resource)" class="text-gray-400 hover:text-red-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">{{ resource.title || 'Untitled Resource' }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ resource.description ? resource.description.substring(0, 100) + '...' : 'No description available' }}</p>
            <div class="flex items-center justify-between text-sm text-gray-500">
              <span>{{ getFileInfo(resource) }}</span>
              <span>{{ resource.tier_min || 'Any' }} tier</span>
            </div>
            <div v-if="resource.tags && resource.tags.trim()" class="mt-2">
              <div class="flex flex-wrap gap-1">
                <span v-for="tag in resource.tags.split(',')" :key="tag" class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                  {{ tag.trim() }}
                </span>
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

// Lifecycle
onMounted(() => {
  loadResources()
})
</script>
