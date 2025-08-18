import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import http from '@/api/http'

export interface User {
  id: number
  name: string
  email: string
  email_verified_at: string | null
  org?: string
  role: 'member' | 'admin'
  country?: string
  profession?: string
  bio?: string
  avatar_url?: string
  privacy_opt_out: boolean
  subscription?: {
    id: number
    status: string
    current_period_end: string
    plan: {
      id: number
      code: string
      name: string
      price_cents: number
      billing_cycle: string
      features: string[]
    }
  }
}

export const useAuthStore = defineStore('auth', () => {
  const token = ref<string | null>(localStorage.getItem('token'))
  const user = ref<User | null>(null)
  const initialized = ref(false)

  const isAuthenticated = computed(() => !!token.value && !!user.value)
  const isAdmin = computed(() => user.value?.role === 'admin')
  const currentTier = computed(() => user.value?.subscription?.plan?.code || 'FREE_MONTHLY')

  async function initialize() {
    if (token.value) {
      http.defaults.headers.common.Authorization = `Bearer ${token.value}`
      try {
        await fetchUser()
      } catch (error) {
        logout()
      }
    }
    initialized.value = true
  }

  async function login(email: string, password: string) {
    const response = await http.post('/auth/login', { email, password })
    token.value = response.data.token
    user.value = response.data.user
    
    localStorage.setItem('token', token.value!)
    http.defaults.headers.common.Authorization = `Bearer ${token.value}`
    
    return response.data
  }

  async function register(userData: {
    name: string
    email: string
    password: string
    password_confirmation: string
    country?: string
    org?: string
    profession?: string
    plan_code?: string
  }) {
    const response = await http.post('/auth/register', userData)
    return response.data
  }

  async function logout() {
    if (token.value) {
      try {
        await http.post('/auth/logout')
      } catch (error) {
        // Ignore errors on logout
      }
    }
    
    token.value = null
    user.value = null
    localStorage.removeItem('token')
    delete http.defaults.headers.common.Authorization
  }

  async function fetchUser() {
    const response = await http.get('/auth/me')
    user.value = response.data.user
    return response.data
  }

  async function updateProfile(profileData: Partial<User>) {
    const response = await http.put('/auth/me', profileData)
    user.value = response.data.user
    return response.data
  }

  async function forgotPassword(email: string) {
    const response = await http.post('/auth/forgot', { email })
    return response.data
  }

  async function resetPassword(resetData: {
    token: string
    email: string
    password: string
    password_confirmation: string
  }) {
    const response = await http.post('/auth/reset', resetData)
    return response.data
  }

  async function verifyEmail(token: string) {
    const response = await http.post('/auth/verify', { token })
    if (user.value) {
      user.value.email_verified_at = new Date().toISOString()
    }
    return response.data
  }

  return {
    token,
    user,
    initialized,
    isAuthenticated,
    isAdmin,
    currentTier,
    initialize,
    login,
    register,
    logout,
    fetchUser,
    updateProfile,
    forgotPassword,
    resetPassword,
    verifyEmail
  }
})
