import http from '@/api/http'

export interface PortalStats {
  upcoming_events: number
  new_resources: number
  active_members: number
  announcements: Array<{
    id: number
    title: string
    content: string
    priority: string
    created_at: string
    author: {
      name: string
    }
  }>
  recent_events: Array<{
    id: number
    title: string
    description: string
    starts_at: string
    ends_at: string
    location_type: string
    location_text: string
    attendees_count: number
  }>
}

export interface Resource {
  id: number
  title: string
  description: string
  category: string
  type: string
  file_path?: string
  external_url?: string
  file_size?: number
  created_at: string
  updated_at: string
}

export interface Event {
  id: number
  title: string
  description: string
  starts_at: string
  ends_at: string
  location_type: string
  location_text: string
  tier_min: string
  rsvp_required: boolean
  attendees_count: number
  user_rsvp?: {
    id: number
    status: string
  }
}

export interface Member {
  id: number
  name: string
  email: string
  org?: string
  country?: string
  profession?: string
  created_at: string
}

export interface Announcement {
  id: number
  title: string
  content: string
  priority: string
  status: string
  created_at: string
  scheduled_at?: string
  author: {
    name: string
  }
}

export const portalService = {
  async getDashboardStats(): Promise<PortalStats> {
    const response = await http.get('/portal/dashboard')
    return response.data
  },

  async getResources(params?: {
    search?: string
    category?: string
    type?: string
    page?: number
  }) {
    const response = await http.get('/portal/resources', { params })
    return response.data
  },

  async getEvents(params?: {
    search?: string
    location_type?: string
    upcoming?: boolean
    page?: number
  }) {
    const response = await http.get('/portal/events', { params })
    return response.data
  },

  async rsvpEvent(eventId: number, status: 'attending' | 'not_attending') {
    const response = await http.post(`/portal/events/${eventId}/rsvp`, { status })
    return response.data
  },

  async getMembers(params?: {
    search?: string
    country?: string
    profession?: string
    page?: number
  }) {
    const response = await http.get('/portal/members', { params })
    return response.data
  },

  async getAnnouncements(params?: {
    priority?: string
    page?: number
  }) {
    const response = await http.get('/portal/announcements', { params })
    return response.data
  },

  async downloadResource(resourceId: number) {
    const response = await http.get(`/portal/resources/${resourceId}/download`, {
      responseType: 'blob'
    })
    return response
  }
}
