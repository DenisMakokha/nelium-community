<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-white">Announcements</h1>
          <p class="text-blue-200">Manage community announcements and notifications</p>
        </div>
        <button @click="openAddModal" class="btn bg-white text-navy hover:bg-gray-100">Add Announcement</button>
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

        <div v-else class="divide-y divide-gray-200">
          <div v-if="!loading && announcements?.data?.length === 0" class="text-center py-8 text-gray-500">
            No announcements found
          </div>

          <div v-if="!loading && announcements?.data?.length > 0" class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                  <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="announcement in announcements.data" :key="announcement.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ announcement.title }}</div>
                    <div class="text-sm text-gray-500">{{ announcement.content.substring(0, 100) }}...</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="getStatusClass(announcement.status)" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                      {{ announcement.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="getPriorityClass(announcement.priority)" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                      {{ announcement.priority }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ announcement.author?.name || 'Unknown' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ formatDate(announcement.created_at) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button @click="editAnnouncement(announcement)" class="text-blueA hover:text-blue-900 mr-3">Edit</button>
                    <button @click="deleteAnnouncement(announcement)" class="text-red-600 hover:text-red-900">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
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
