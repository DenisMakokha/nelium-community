<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-white">Events</h1>
          <p class="text-blue-200">Manage community events</p>
        </div>
        <button @click="openAddModal" class="btn bg-white text-navy hover:bg-gray-100">Create Event</button>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg p-6 shadow mb-6">
        <div class="flex flex-wrap gap-4">
          <input 
            v-model="filters.search" 
            @input="debouncedSearch"
            type="search" 
            placeholder="Search events..." 
            class="form-input flex-1 max-w-md"
          >
          <select v-model="filters.location_type" @change="loadEvents" class="form-input w-auto">
            <option value="all">All Types</option>
            <option value="online">Online</option>
            <option value="physical">Physical</option>
            <option value="hybrid">Hybrid</option>
          </select>
          <select v-model="filters.tier" @change="loadEvents" class="form-input w-auto">
            <option value="all">All Tiers</option>
            <option value="FREE">Free</option>
            <option value="IND">Individual</option>
            <option value="INST">Institutional</option>
          </select>
        </div>
      </div>

      <!-- Events List -->
      <div class="bg-white rounded-lg shadow">
        <div v-if="loading" class="flex justify-center items-center py-12">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blueA mx-auto"></div>
          <p class="mt-2 text-gray-600">Loading events...</p>
        </div>
        
        <div v-if="!loading && events?.data?.length === 0" class="text-center py-8 text-gray-500">
          No events found
        </div>

        <div v-if="!loading && events?.data?.length > 0" class="divide-y divide-gray-200">
          <div v-for="event in events.data" :key="event.id" class="p-6 hover:bg-gray-50">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <div class="flex items-center mb-2">
                  <span :class="getLocationTypeClass(event.location_type)" class="text-xs px-2 py-1 rounded-full mr-2">
                    {{ event.location_type }}
                  </span>
                  <span class="text-sm text-gray-500">{{ formatDateTime(event.starts_at) }}</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ event.title }}</h3>
                <p class="text-gray-600 mb-4">{{ event.description.substring(0, 150) }}...</p>
                <div class="flex items-center text-sm text-gray-500">
                  <span class="mr-4">{{ event.location_text }}</span>
                  <span class="mr-4">{{ event.tier_min }} tier</span>
                  <span v-if="event.rsvp_required" class="text-green-600">RSVP Required</span>
                </div>
              </div>
              <div class="ml-6 flex space-x-2">
                <button @click="editEvent(event)" class="btn btn-sm btn-outline">Edit</button>
                <button @click="deleteEvent(event)" class="btn btn-sm btn-outline text-red-600 border-red-300">Delete</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="events?.last_page > 1" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
          <div class="flex-1 flex justify-between sm:hidden">
            <button 
              @click="changePage(events.current_page - 1)"
              :disabled="events.current_page <= 1"
              class="btn btn-outline btn-sm"
            >
              Previous
            </button>
            <button 
              @click="changePage(events.current_page + 1)"
              :disabled="events.current_page >= events.last_page"
              class="btn btn-outline btn-sm"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing page {{ events.current_page }} of {{ events.last_page }} 
                ({{ events.total }} total events)
              </p>
            </div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
              <button 
                @click="changePage(events.current_page - 1)"
                :disabled="events.current_page <= 1"
                class="btn btn-outline btn-sm"
              >
                Previous
              </button>
              <button 
                @click="changePage(events.current_page + 1)"
                :disabled="events.current_page >= events.last_page"
                class="btn btn-outline btn-sm"
              >
                Next
              </button>
            </nav>
          </div>
        </div>
      </div>

      <!-- Add/Edit Event Modal -->
      <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              {{ showEditModal ? 'Edit Event' : 'Create New Event' }}
            </h3>
            <form @submit.prevent="showEditModal ? updateEvent() : createEvent()">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                  <input 
                    v-model="eventForm.title" 
                    type="text" 
                    required 
                    class="form-input w-full"
                    placeholder="Enter event title"
                  >
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                  <textarea 
                    v-model="eventForm.description" 
                    required 
                    rows="4"
                    class="form-input w-full"
                  ></textarea>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Start Date & Time</label>
                  <input 
                    v-model="eventForm.starts_at" 
                    type="datetime-local" 
                    required 
                    class="form-input w-full"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">End Date & Time</label>
                  <input 
                    v-model="eventForm.ends_at" 
                    type="datetime-local" 
                    required 
                    class="form-input w-full"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Location Type</label>
                  <select v-model="eventForm.location_type" class="form-input w-full">
                    <option value="online">Online</option>
                    <option value="physical">Physical</option>
                    <option value="hybrid">Hybrid</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Tier</label>
                  <select v-model="eventForm.tier_min" class="form-input w-full">
                    <option value="FREE">Free</option>
                    <option value="IND">Individual</option>
                    <option value="INST">Institutional</option>
                  </select>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Location Details</label>
                  <input 
                    v-model="eventForm.location_text" 
                    type="text" 
                    required 
                    class="form-input w-full"
                    placeholder="Enter location details (URL, address, etc.)"
                  >
                </div>
                <div class="md:col-span-2">
                  <label class="flex items-center">
                    <input 
                      v-model="eventForm.rsvp_required" 
                      type="checkbox" 
                      class="form-checkbox"
                    >
                    <span class="ml-2 text-sm text-gray-700">RSVP Required</span>
                  </label>
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
import { ref, onMounted } from 'vue'
import { adminService } from '@/services/adminService'
import { debounce } from 'lodash'

interface Event {
  id: number
  title: string
  slug: string
  description: string
  starts_at: string
  ends_at: string
  location_type: string
  location_text: string
  tier_min: string
  rsvp_required: boolean
  created_at: string
  updated_at: string
}

interface EventsResponse {
  data: Event[]
  current_page: number
  last_page: number
  total: number
  per_page: number
}

// Reactive data
const loading = ref(false)
const formLoading = ref(false)
const events = ref<EventsResponse | null>(null)
const showAddModal = ref(false)
const showEditModal = ref(false)
const editingEvent = ref<Event | null>(null)

// Filters
const filters = ref({
  search: '',
  location_type: 'all',
  tier: 'all',
  page: 1
})

// Form data
const eventForm = ref({
  title: '',
  description: '',
  starts_at: '',
  ends_at: '',
  location_type: 'online',
  location_text: '',
  tier_min: 'FREE',
  rsvp_required: false
})

// Methods
const loadEvents = async () => {
  try {
    loading.value = true
    const params: any = {
      page: filters.value.page
    }
    
    if (filters.value.search) params.search = filters.value.search
    if (filters.value.location_type !== 'all') params.location_type = filters.value.location_type
    if (filters.value.tier !== 'all') params.tier = filters.value.tier
    
    const response = await adminService.getEvents(params)
    events.value = response
  } catch (error) {
    console.error('Error loading events:', error)
  } finally {
    loading.value = false
  }
}

const debouncedSearch = debounce(() => {
  filters.value.page = 1
  loadEvents()
}, 300)

const changePage = (page: number) => {
  filters.value.page = page
  loadEvents()
}

const openAddModal = () => {
  resetForm()
  showAddModal.value = true
}

const editEvent = (event: Event) => {
  editingEvent.value = event
  eventForm.value = {
    title: event.title,
    description: event.description,
    starts_at: formatDateTimeForInput(event.starts_at),
    ends_at: formatDateTimeForInput(event.ends_at),
    location_type: event.location_type,
    location_text: event.location_text,
    tier_min: event.tier_min,
    rsvp_required: event.rsvp_required
  }
  showEditModal.value = true
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  editingEvent.value = null
  resetForm()
}

const resetForm = () => {
  eventForm.value = {
    title: '',
    description: '',
    starts_at: '',
    ends_at: '',
    location_type: 'online',
    location_text: '',
    tier_min: 'FREE',
    rsvp_required: false
  }
}

const createEvent = async () => {
  try {
    formLoading.value = true
    await adminService.createEvent(eventForm.value)
    closeModal()
    loadEvents()
  } catch (error: any) {
    console.error('Error creating event:', error)
    alert(error.response?.data?.message || 'Error creating event')
  } finally {
    formLoading.value = false
  }
}

const updateEvent = async () => {
  if (!editingEvent.value) return

  try {
    formLoading.value = true
    await adminService.updateEvent(editingEvent.value.id, eventForm.value)
    closeModal()
    loadEvents()
  } catch (error: any) {
    console.error('Error updating event:', error)
    alert(error.response?.data?.message || 'Error updating event')
  } finally {
    formLoading.value = false
  }
}

const deleteEvent = async (event: Event) => {
  if (!confirm(`Are you sure you want to delete "${event.title}"?`)) {
    return
  }

  try {
    await adminService.deleteEvent(event.id)
    loadEvents()
  } catch (error: any) {
    console.error('Error deleting event:', error)
    alert(error.response?.data?.message || 'Error deleting event')
  }
}

const getLocationTypeClass = (locationType: string) => {
  const classes = {
    online: 'bg-blue-100 text-blue-800',
    physical: 'bg-green-100 text-green-800',
    hybrid: 'bg-purple-100 text-purple-800'
  }
  return classes[locationType as keyof typeof classes] || 'bg-gray-100 text-gray-800'
}

const formatDateTime = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatDateTimeForInput = (dateString: string) => {
  const date = new Date(dateString)
  return date.toISOString().slice(0, 16)
}

// Lifecycle
onMounted(() => {
  loadEvents()
})
</script>
