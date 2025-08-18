import http from '@/api/http'

export interface DashboardStats {
  total_members: number
  total_admins: number
  active_subscriptions: number
  monthly_revenue: number
  total_revenue: number
  recent_members: Array<{
    id: number
    name: string
    email: string
    created_at: string
  }>
  recent_payments: Array<{
    id: number
    amount_cents: number
    status: string
    created_at: string
    user: {
      name: string
      email: string
    }
    subscription: {
      plan: {
        name: string
      }
    }
  }>
  subscription_breakdown: Array<{
    name: string
    count: number
  }>
  monthly_signups: Array<{
    date: string
    count: number
  }>
}

export interface Member {
  id: number
  name: string
  email: string
  created_at: string
  subscription?: {
    id: number
    status: string
    plan: {
      id: number
      name: string
      code: string
    }
  }
}

export interface Payment {
  id: number
  amount_cents: number
  currency: string
  status: string
  created_at: string
  user: {
    name: string
    email: string
  }
  subscription: {
    plan: {
      name: string
    }
  }
}

export interface Subscription {
  id: number
  status: string
  current_period_start: string
  current_period_end: string
  user: {
    name: string
    email: string
  }
  plan: {
    name: string
    code: string
    price_cents: number
  }
}

export const adminService = {
  async getDashboardStats(): Promise<DashboardStats> {
    const response = await http.get('/admin/dashboard')
    return response.data
  },

  async getMembers(params?: {
    search?: string
    plan?: string
    status?: string
    page?: number
  }) {
    const response = await http.get('/admin/members', { params })
    return response.data
  },

  async updateMember(userId: number, data: {
    name?: string
    email?: string
    plan_id?: number
  }) {
    const response = await http.put(`/admin/members/${userId}`, data)
    return response.data
  },

  async createMember(data: {
    name: string
    email: string
    org?: string
    country?: string
    profession?: string
    password: string
  }) {
    const response = await http.post('/admin/members', data)
    return response.data
  },

  async suspendMember(userId: number) {
    const response = await http.put(`/admin/members/${userId}/suspend`)
    return response.data
  },

  async deleteMember(userId: number) {
    const response = await http.delete(`/admin/members/${userId}`)
    return response.data
  },

  async getPayments(params?: {
    status?: string
    from?: string
    to?: string
    page?: number
  }) {
    const response = await http.get('/admin/payments', { params })
    return response.data
  },

  async getSubscriptions(params?: {
    status?: string
    plan?: string
    page?: number
  }) {
    const response = await http.get('/admin/subscriptions', { params })
    return response.data
  },

  async getReports() {
    const response = await http.get('/admin/reports')
    return response.data
  },

  async getAuditLogs(params?: {
    action?: string
    from?: string
    to?: string
    page?: number
  }) {
    const response = await http.get('/admin/audit-logs', { params })
    return response.data
  },

  async getAnnouncements(params?: {
    search?: string
    status?: string
    priority?: string
    page?: number
  }) {
    const response = await http.get('/admin/announcements', { params })
    return response.data
  },

  async createAnnouncement(data: {
    title: string
    content: string
    priority: string
    status: string
    scheduled_at?: string
  }) {
    const response = await http.post('/admin/announcements', data)
    return response.data
  },

  async updateAnnouncement(id: number, data: {
    title?: string
    content?: string
    priority?: string
    status?: string
    scheduled_at?: string
  }) {
    const response = await http.put(`/admin/announcements/${id}`, data)
    return response.data
  },

  async deleteAnnouncement(id: number) {
    const response = await http.delete(`/admin/announcements/${id}`)
    return response.data
  },

  async getEvents(params?: {
    search?: string
    location_type?: string
    tier?: string
    page?: number
  }) {
    const response = await http.get('/admin/events', { params })
    return response.data
  },

  async createEvent(data: {
    title: string
    description: string
    starts_at: string
    ends_at: string
    location_type: string
    location_text: string
    tier_min: string
    rsvp_required?: boolean
  }) {
    const response = await http.post('/admin/events', data)
    return response.data
  },

  async updateEvent(id: number, data: {
    title?: string
    description?: string
    starts_at?: string
    ends_at?: string
    location_type?: string
    location_text?: string
    tier_min?: string
    rsvp_required?: boolean
  }) {
    const response = await http.put(`/admin/events/${id}`, data)
    return response.data
  },

  async deleteEvent(id: number) {
    const response = await http.delete(`/admin/events/${id}`)
    return response.data
  },

  async getResources(params?: {
    search?: string
    category?: string
    tier?: string
    page?: number
  }) {
    const response = await http.get('/admin/resources', { params })
    return response.data
  },

  async createResource(formData: FormData) {
    const response = await http.post('/admin/resources', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    return response.data
  },

  async updateResource(id: number, formData: FormData) {
    const response = await http.post(`/admin/resources/${id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-HTTP-Method-Override': 'PUT'
      }
    })
    return response.data
  },

  async deleteResource(id: number) {
    const response = await http.delete(`/admin/resources/${id}`)
    return response.data
  }
}
