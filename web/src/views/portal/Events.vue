<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-heading font-semibold text-navy-900">Community Events</h1>
        <p class="text-navy-600 text-lg">Discover and join upcoming community events</p>
      </div>

      <!-- Filter Bar -->
      <div class="mb-6 flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
        <select v-model="filters.location_type" @change="loadEvents" class="form-input w-full sm:w-auto">
          <option value="">All Events</option>
          <option value="virtual">Virtual</option>
          <option value="in_person">In-Person</option>
        </select>
        <input v-model="filters.search" @input="debouncedSearch" type="search" placeholder="Search events..." class="form-input flex-1 w-full sm:max-w-md">
      </div>

      <!-- Events List -->
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
        <p class="text-navy-600 mt-4">Loading events...</p>
      </div>
      
      <div v-else-if="error" class="text-center py-12">
        <p class="text-red-600 mb-4">{{ error }}</p>
        <button @click="loadEvents" class="text-primary-600 hover:text-primary-700">Try again</button>
      </div>
      
      <div v-else-if="events.length" class="space-y-6">
        <div v-for="event in events" :key="event.id" class="card hover:shadow-lg transition-shadow">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center mb-2">
                <span :class="[
                  'text-xs px-2 py-1 rounded-full mr-2',
                  event.location_type === 'virtual' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'
                ]">
                  {{ event.location_type === 'virtual' ? 'Virtual' : 'In-Person' }}
                </span>
                <span class="text-sm text-gray-500">{{ formatEventDate(event.starts_at) }}</span>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ event.title }}</h3>
              <p class="text-gray-600 mb-4 line-clamp-2">{{ event.description }}</p>
              <div class="flex items-center text-sm text-gray-500">
                <svg v-if="event.location_type === 'virtual'" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <svg v-else class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ event.location_type === 'virtual' ? event.attendees_count + ' attending' : event.location_text }}
              </div>
            </div>
            <div class="ml-6 flex flex-col space-y-2">
              <button @click="handleRSVP(event)" :class="[
                'btn',
                event.user_rsvp?.status === 'attending' ? 'btn-primary' : 'btn-outline'
              ]">
                {{ event.user_rsvp?.status === 'attending' ? 'Attending' : 'RSVP' }}
              </button>
              <RouterLink :to="`/portal/events/${event.id}`" class="btn btn-outline">View Details</RouterLink>
            </div>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-12">
        <p class="text-navy-600">No events found</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { debounce } from 'lodash'
import { portalService, type Event } from '@/services/portalService'

const events = ref<Event[]>([])
const loading = ref(true)
const error = ref('')
const filters = ref({
  search: '',
  location_type: ''
})

const loadEvents = async () => {
  try {
    loading.value = true
    error.value = ''
    const response = await portalService.getEvents({
      ...filters.value,
      upcoming: true
    })
    events.value = response.data || []
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Failed to load events'
    console.error('Events error:', err)
  } finally {
    loading.value = false
  }
}

const debouncedSearch = debounce(() => {
  loadEvents()
}, 300)

const formatEventDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
    hour: 'numeric',
    minute: '2-digit',
    hour12: true
  })
}

const handleRSVP = async (event: Event) => {
  try {
    const status = event.user_rsvp?.status === 'attending' ? 'not_attending' : 'attending'
    await portalService.rsvpEvent(event.id, status)
    await loadEvents() // Refresh to get updated RSVP status
  } catch (err: any) {
    console.error('RSVP error:', err)
    error.value = err.response?.data?.message || 'Failed to update RSVP'
  }
}

onMounted(() => {
  loadEvents()
})
</script>
