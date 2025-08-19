<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h1 class="text-3xl sm:text-4xl font-heading font-semibold text-navy-900">Announcements</h1>
          <p class="text-navy-600 text-lg">Manage community announcements and notifications</p>
        </div>
        <button @click="openAddModal" class="w-full sm:w-auto bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-lg font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
          <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
          </svg>
          Add Announcement
        </button>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg p-6 shadow mb-6">
        <div class="flex flex-wrap gap-4">
          <input 
            v-model="filters.search" 
            @input="debouncedSearch"
            type="search" 
            placeholder="Search announcements..." 
            class="form-input flex-1 max-w-md"
          >
          <select v-model="filters.status" @change="loadAnnouncements" class="form-input">
            <option value="all">All Status</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
          </select>
          <select v-model="filters.type" @change="loadAnnouncements" class="form-input">
            <option value="all">All Types</option>
            <option value="general">General</option>
            <option value="event">Event</option>
            <option value="maintenance">Maintenance</option>
            <option value="urgent">Urgent</option>
          </select>
        </div>
      </div>

      <!-- Announcements List -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div v-if="loading" class="p-8 text-center">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blueA mx-auto"></div>
          <p class="mt-2 text-gray-600">Loading announcements...</p>
        </div>
        
        <div v-else-if="!announcements || !announcements.data || announcements.data.length === 0" class="p-8 text-center text-gray-500">
          <p>No announcements found</p>
          <p class="text-sm mt-2">Create your first announcement to get started</p>
        </div>

        <div v-else>
          <!-- Modern Card Layout -->
          <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 p-6">
            <div v-for="announcement in announcements.data" :key="announcement.id" 
                 class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group hover:scale-105 border border-gray-100">
              <div class="p-6">
                <!-- Header with Priority and Actions -->
                <div class="flex items-start justify-between mb-4">
                  <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg v-if="announcement.priority === 'high'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <svg v-else-if="announcement.priority === 'medium'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <svg v-else class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <div class="flex items-center space-x-2">
                    <span :class="getPriorityClass(announcement.priority)" class="px-3 py-1 text-xs font-medium rounded-full">
                      {{ announcement.priority }}
                    </span>
                    <span :class="getStatusClass(announcement.status)" class="px-3 py-1 text-xs font-medium rounded-full">
                      {{ announcement.status }}
                    </span>
                  </div>
                </div>

                <!-- Title and Content -->
                <h3 class="text-xl font-semibold text-navy-900 mb-3 group-hover:text-primary-600 transition-colors line-clamp-2">
                  {{ announcement.title }}
                </h3>
                <p class="text-navy-600 mb-4 leading-relaxed line-clamp-3">
                  {{ announcement.content }}
                </p>

                <!-- Metadata -->
                <div class="flex items-center justify-between text-sm text-navy-500 mb-4">
                  <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ announcement.author?.name || 'Unknown' }}
                  </span>
                  <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ formatDate(announcement.created_at) }}
                  </span>
                </div>

                <!-- Scheduled Info -->
                <div v-if="announcement.scheduled_at" class="flex items-center text-sm text-amber-600 mb-4 bg-amber-50 px-3 py-2 rounded-lg">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  Scheduled: {{ formatDate(announcement.scheduled_at) }}
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                  <button @click="editAnnouncement(announcement)" 
                          class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-2 px-4 rounded-lg font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:shadow-md text-sm">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                  </button>
                  <button @click="deleteAnnouncement(announcement)" 
                          class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white py-2 px-4 rounded-lg font-medium hover:from-red-600 hover:to-red-700 transition-all duration-200 hover:shadow-md text-sm">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div v-if="announcements?.last_page > 1" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
              <button 
                @click="changePage(announcements.current_page - 1)"
                :disabled="announcements.current_page <= 1"
                class="btn btn-outline btn-sm"
              >
                Previous
              </button>
              <button 
                @click="changePage(announcements.current_page + 1)"
                :disabled="announcements.current_page >= announcements.last_page"
                class="btn btn-outline btn-sm"
              >
                Next
              </button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing page {{ announcements.current_page }} of {{ announcements.last_page }} 
                  ({{ announcements.total }} total announcements)
                </p>
              </div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <button 
                  @click="changePage(announcements.current_page - 1)"
                  :disabled="announcements.current_page <= 1"
                  class="btn btn-outline btn-sm"
                >
                  Previous
                </button>
                <button 
                  @click="changePage(announcements.current_page + 1)"
                  :disabled="announcements.current_page >= announcements.last_page"
                  class="btn btn-outline btn-sm"
                >
                  Next
              </button>
              </nav>
            </div>
          </div>
        </div>
        
      </div>

      <!-- Add/Edit Announcement Modal -->
      <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              {{ showEditModal ? 'Edit Announcement' : 'Add New Announcement' }}
            </h3>
            <form @submit.prevent="showEditModal ? updateAnnouncement() : createAnnouncement()">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input 
                  v-model="announcementForm.title" 
                  type="text" 
                  required 
                  class="form-input w-full"
                  placeholder="Enter announcement title"
                >
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <textarea 
                  v-model="announcementForm.content" 
                  required 
                  rows="4"
                  class="form-input w-full"
                  placeholder="Enter announcement content"
                ></textarea>
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                <select v-model="announcementForm.priority" class="form-input w-full">
                  <option value="low">Low</option>
                  <option value="medium">Medium</option>
                  <option value="high">High</option>
                </select>
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select v-model="announcementForm.status" class="form-input w-full">
                  <option value="draft">Draft</option>
                  <option value="published">Published</option>
                  <option value="archived">Archived</option>
                </select>
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled At (Optional)</label>
                <input 
                  v-model="announcementForm.scheduled_at" 
                  type="datetime-local" 
                  class="form-input w-full"
                >
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
import { ref, reactive, onMounted } from 'vue'
import { adminService } from '@/services/adminService'
import { debounce } from 'lodash-es'

const loading = ref(true)
const showAddModal = ref(false)
const showEditModal = ref(false)
const formLoading = ref(false)
const editingAnnouncement = ref<any>(null)

const filters = reactive({
  search: '',
  status: 'all',
  priority: 'all',
  type: 'all',
  page: 1
})

const announcementForm = reactive({
  title: '',
  content: '',
  priority: 'medium',
  status: 'draft',
  scheduled_at: ''
})

const announcements = ref<any>(null)

const loadAnnouncements = async () => {
  try {
    loading.value = true
    console.log('Loading announcements...')
    const params = {
      search: filters.search || undefined,
      status: filters.status !== 'all' ? filters.status : undefined,
      priority: filters.priority !== 'all' ? filters.priority : undefined,
      page: filters.page
    }
    console.log('API params:', params)
    const result = await adminService.getAnnouncements(params)
    console.log('API response:', result)
    announcements.value = result
    console.log('Announcements loaded:', announcements.value)
  } catch (error: any) {
    console.error('Failed to load announcements:', error)
    console.error('Error details:', error.response?.data || error.message)
    alert('Failed to load announcements: ' + (error.response?.data?.message || error.message))
  } finally {
    loading.value = false
  }
}

const debouncedSearch = debounce(() => {
  filters.page = 1
  loadAnnouncements()
}, 300)

const changePage = (page: number) => {
  filters.page = page
  loadAnnouncements()
}

const openAddModal = () => {
  resetForm()
  showAddModal.value = true
}

const createAnnouncement = async () => {
  try {
    formLoading.value = true
    await adminService.createAnnouncement(announcementForm)
    closeModal()
    loadAnnouncements()
    alert('Announcement created successfully!')
  } catch (error: any) {
    console.error('Failed to create announcement:', error)
    alert('Failed to create announcement: ' + (error.response?.data?.message || error.message))
  } finally {
    formLoading.value = false
  }
}

const editAnnouncement = (announcement: any) => {
  editingAnnouncement.value = announcement
  announcementForm.title = announcement.title
  announcementForm.content = announcement.content
  announcementForm.priority = announcement.priority
  announcementForm.status = announcement.status
  announcementForm.scheduled_at = announcement.scheduled_at || ''
  showEditModal.value = true
}

const updateAnnouncement = async () => {
  if (!editingAnnouncement.value) return
  
  try {
    formLoading.value = true
    await adminService.updateAnnouncement(editingAnnouncement.value.id, announcementForm)
    closeModal()
    loadAnnouncements()
    alert('Announcement updated successfully!')
  } catch (error: any) {
    console.error('Failed to update announcement:', error)
    alert('Failed to update announcement: ' + (error.response?.data?.message || error.message))
  } finally {
    formLoading.value = false
  }
}

const deleteAnnouncement = async (announcement: any) => {
  if (confirm(`Are you sure you want to delete "${announcement.title}"? This action cannot be undone.`)) {
    try {
      await adminService.deleteAnnouncement(announcement.id)
      loadAnnouncements()
      alert('Announcement deleted successfully!')
    } catch (error: any) {
      console.error('Failed to delete announcement:', error)
      alert('Failed to delete announcement: ' + (error.response?.data?.message || error.message))
    }
  }
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  editingAnnouncement.value = null
  resetForm()
}

const resetForm = () => {
  announcementForm.title = ''
  announcementForm.content = ''
  announcementForm.priority = 'medium'
  announcementForm.status = 'draft'
  announcementForm.scheduled_at = ''
}

const getStatusClass = (status: string) => {
  switch (status?.toLowerCase()) {
    case 'published':
      return 'bg-green-100 text-green-800'
    case 'draft':
      return 'bg-yellow-100 text-yellow-800'
    case 'archived':
      return 'bg-gray-100 text-gray-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getPriorityClass = (priority: string) => {
  switch (priority?.toLowerCase()) {
    case 'high':
      return 'bg-red-100 text-red-800'
    case 'medium':
      return 'bg-yellow-100 text-yellow-800'
    case 'low':
      return 'bg-green-100 text-green-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getTypeClass = (type: string) => {
  switch (type?.toLowerCase()) {
    case 'urgent':
      return 'bg-red-100 text-red-800'
    case 'event':
      return 'bg-blue-100 text-blue-800'
    case 'maintenance':
      return 'bg-orange-100 text-orange-800'
    case 'general':
      return 'bg-purple-100 text-purple-800'
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
  loadAnnouncements()
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
