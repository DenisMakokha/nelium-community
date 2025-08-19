<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h1 class="text-3xl sm:text-4xl font-heading font-semibold text-navy-900">Members</h1>
          <p class="text-navy-600 text-lg">Manage community members ({{ membersData?.total || 0 }} total)</p>
        </div>
        <button @click="showAddModal = true" class="w-full sm:w-auto bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-lg font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
          <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Add Member
        </button>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg p-6 shadow mb-6">
        <div class="flex flex-wrap gap-4">
          <input 
            v-model="filters.search" 
            @input="debouncedSearch"
            type="search" 
            placeholder="Search members..." 
            class="form-input flex-1 max-w-md"
          >
          <select v-model="filters.plan" @change="loadMembers" class="form-input">
            <option value="all">All Plans</option>
            <option value="basic">Basic</option>
            <option value="premium">Premium</option>
            <option value="enterprise">Enterprise</option>
          </select>
          <select v-model="filters.status" @change="loadMembers" class="form-input">
            <option value="all">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
          </select>
        </div>
      </div>

      <!-- Members Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div v-if="loading" class="p-8 text-center">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blueA mx-auto"></div>
          <p class="mt-2 text-gray-600">Loading members...</p>
        </div>
        
        <div v-else-if="!membersData || !membersData.data || membersData.data.length === 0" class="p-8 text-center text-gray-500">
          <p>No members found</p>
        </div>

        <table v-else class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gradient-to-r from-navy-50 to-primary-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Member</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Plan</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Joined</th>
              <th class="px-6 py-4 text-right text-xs font-semibold text-navy-700 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            <!-- Loading Skeleton -->
            <template v-if="loading">
              <SkeletonLoader v-for="i in 5" :key="i" type="table-row" />
            </template>
            
            <!-- Actual Data -->
            <template v-else>
              <tr v-for="(member, index) in membersData?.data" :key="member.id" 
                  :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'" 
                  class="hover:bg-primary-50 transition-colors duration-150 group">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="h-9 w-9 rounded-lg bg-gradient-to-r from-primary-500 to-primary-600 text-white flex items-center justify-center text-xs font-semibold shadow-sm group-hover:scale-105 transition-transform">
                      {{ getInitials(member.name) }}
                    </div>
                    <div class="ml-3">
                      <div class="text-sm font-semibold text-navy-900 group-hover:text-primary-700 transition-colors">{{ member.name }}</div>
                      <div class="text-sm text-navy-500">{{ member.email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-navy-700">
                  {{ member.phone || 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusClass(member.subscription_status)" class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full">
                    <div class="w-2 h-2 rounded-full mr-2" :class="getStatusDotClass(member.subscription_status)"></div>
                    {{ member.subscription_status || 'inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-navy-700 font-medium">{{ formatDate(member.created_at) }}</div>
                  <div class="text-xs text-navy-500">{{ getRelativeTime(member.created_at) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right">
                  <div class="flex items-center justify-end space-x-2">
                    <button @click="editMember(member)" 
                            class="inline-flex items-center p-2 text-primary-600 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-all duration-200 hover:scale-105"
                            title="Edit Member">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </button>
                    <button @click="suspendMember(member)" 
                            class="inline-flex items-center p-2 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-all duration-200 hover:scale-105"
                            title="Suspend Member">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                      </svg>
                    </button>
                    <button @click="deleteMember(member)" 
                            class="inline-flex items-center p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 hover:scale-105"
                            title="Delete Member">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="!membersData?.data?.length">
                <td colspan="5" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-navy-100 rounded-full flex items-center justify-center mb-4">
                      <svg class="w-8 h-8 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                      </svg>
                    </div>
                    <p class="text-navy-500 text-lg font-medium">No members found</p>
                    <p class="text-navy-400 text-sm">Members will appear here once they join your community</p>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
        
        <!-- Pagination -->
        <div v-if="membersData?.last_page > 1" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
          <div class="flex-1 flex justify-between sm:hidden">
            <button 
              @click="changePage(membersData.current_page - 1)"
              :disabled="membersData.current_page <= 1"
              class="btn btn-outline"
            >
              Previous
            </button>
            <button 
              @click="changePage(membersData.current_page + 1)"
              :disabled="membersData.current_page >= membersData.last_page"
              class="btn btn-outline"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing {{ (membersData.current_page - 1) * membersData.per_page + 1 }} to {{ Math.min(membersData.current_page * membersData.per_page, membersData.total) }} of {{ membersData.total }} results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <button 
                  @click="changePage(membersData.current_page - 1)"
                  :disabled="membersData.current_page <= 1"
                  class="btn btn-outline btn-sm"
                >
                  Previous
                </button>
                <button 
                  @click="changePage(membersData.current_page + 1)"
                  :disabled="membersData.current_page >= membersData.last_page"
                  class="btn btn-outline btn-sm"
                >
                  Next
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!-- Add/Edit Member Modal -->
      <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              {{ showEditModal ? 'Edit Member' : 'Add New Member' }}
            </h3>
            <form @submit.prevent="showEditModal ? updateMember() : createMember()">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input 
                  v-model="memberForm.name" 
                  type="text" 
                  required 
                  class="form-input w-full"
                  placeholder="Enter member name"
                >
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                  v-model="memberForm.email" 
                  type="email" 
                  required 
                  class="form-input w-full"
                  placeholder="Enter email address"
                >
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Organization</label>
                <input 
                  v-model="memberForm.org" 
                  type="text" 
                  class="form-input w-full"
                  placeholder="Enter organization"
                >
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                <input 
                  v-model="memberForm.country" 
                  type="text" 
                  class="form-input w-full"
                  placeholder="Enter country"
                >
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Profession</label>
                <input 
                  v-model="memberForm.profession" 
                  type="text" 
                  class="form-input w-full"
                  placeholder="Enter profession"
                >
              </div>
              <div v-if="!showEditModal" class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input 
                  v-model="memberForm.password" 
                  type="password" 
                  required 
                  class="form-input w-full"
                  placeholder="Enter password"
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
                  :disabled="memberFormLoading"
                  class="btn bg-blueA text-white hover:bg-blue-700"
                >
                  {{ memberFormLoading ? 'Saving...' : (showEditModal ? 'Update' : 'Create') }}
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
import { ref, onMounted, reactive, computed } from 'vue'
import { adminService, type Member } from '@/services/adminService'
import { debounce } from 'lodash-es'
import SkeletonLoader from '@/components/SkeletonLoader.vue'

const loading = ref(true)
const membersData = ref<any>(null)
const showAddModal = ref(false)
const showEditModal = ref(false)
const memberFormLoading = ref(false)
const editingMember = ref<Member | null>(null)

const filters = reactive({
  search: '',
  plan: 'all',
  status: 'all',
  page: 1
})

const memberForm = reactive({
  name: '',
  email: '',
  org: '',
  country: '',
  profession: '',
  password: ''
})

const loadMembers = async () => {
  try {
    loading.value = true
    const params = {
      search: filters.search || undefined,
      plan: filters.plan !== 'all' ? filters.plan : undefined,
      status: filters.status !== 'all' ? filters.status : undefined,
      page: filters.page
    }
    console.log('Loading members with params:', params)
    membersData.value = await adminService.getMembers(params)
    console.log('Members data loaded:', membersData.value)
  } catch (error) {
    console.error('Failed to load members:', error)
    console.error('Error details:', error.response?.data || error.message)
  } finally {
    loading.value = false
  }
}

const debouncedSearch = debounce(() => {
  filters.page = 1
  loadMembers()
}, 300)

const changePage = (page: number) => {
  filters.page = page
  loadMembers()
}

const createMember = async () => {
  try {
    memberFormLoading.value = true
    await adminService.createMember(memberForm)
    closeModal()
    loadMembers()
    alert('Member created successfully!')
  } catch (error: any) {
    console.error('Failed to create member:', error)
    alert('Failed to create member: ' + (error.response?.data?.message || error.message))
  } finally {
    memberFormLoading.value = false
  }
}

const editMember = (member: Member) => {
  editingMember.value = member
  memberForm.name = member.name
  memberForm.email = member.email
  memberForm.org = member.org || ''
  memberForm.country = member.country || ''
  memberForm.profession = member.profession || ''
  memberForm.password = ''
  showEditModal.value = true
}

const updateMember = async () => {
  if (!editingMember.value) return
  
  try {
    memberFormLoading.value = true
    const updateData = {
      name: memberForm.name,
      email: memberForm.email,
      org: memberForm.org,
      country: memberForm.country,
      profession: memberForm.profession
    }
    await adminService.updateMember(editingMember.value.id, updateData)
    closeModal()
    loadMembers()
    alert('Member updated successfully!')
  } catch (error: any) {
    console.error('Failed to update member:', error)
    alert('Failed to update member: ' + (error.response?.data?.message || error.message))
  } finally {
    memberFormLoading.value = false
  }
}

const suspendMember = async (member: Member) => {
  if (confirm(`Are you sure you want to suspend ${member.name}?`)) {
    try {
      await adminService.suspendMember(member.id)
      loadMembers()
      alert('Member suspended successfully!')
    } catch (error: any) {
      console.error('Failed to suspend member:', error)
      alert('Failed to suspend member: ' + (error.response?.data?.message || error.message))
    }
  }
}

const deleteMember = async (member: Member) => {
  if (confirm(`Are you sure you want to delete ${member.name}? This action cannot be undone.`)) {
    try {
      await adminService.deleteMember(member.id)
      loadMembers()
      alert('Member deleted successfully!')
    } catch (error: any) {
      console.error('Failed to delete member:', error)
      alert('Failed to delete member: ' + (error.response?.data?.message || error.message))
    }
  }
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  editingMember.value = null
  memberForm.name = ''
  memberForm.email = ''
  memberForm.org = ''
  memberForm.country = ''
  memberForm.profession = ''
  memberForm.password = ''
}

const getInitials = (name: string) => {
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
}

const getStatusClass = (status: string) => {
  switch (status?.toLowerCase()) {
    case 'active':
      return 'bg-emerald-100 text-emerald-800 border border-emerald-200'
    case 'cancelled':
    case 'inactive':
      return 'bg-red-100 text-red-800 border border-red-200'
    case 'pending':
      return 'bg-amber-100 text-amber-800 border border-amber-200'
    default:
      return 'bg-gray-100 text-gray-800 border border-gray-200'
  }
}

const getStatusDotClass = (status: string) => {
  switch (status?.toLowerCase()) {
    case 'active':
      return 'bg-emerald-500'
    case 'cancelled':
    case 'inactive':
      return 'bg-red-500'
    case 'pending':
      return 'bg-amber-500'
    default:
      return 'bg-gray-500'
  }
}

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const getRelativeTime = (dateString: string) => {
  const date = new Date(dateString)
  const now = new Date()
  const diffTime = Math.abs(now.getTime() - date.getTime())
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  
  if (diffDays === 1) return '1 day ago'
  if (diffDays < 30) return `${diffDays} days ago`
  if (diffDays < 365) return `${Math.floor(diffDays / 30)} months ago`
  return `${Math.floor(diffDays / 365)} years ago`
}

onMounted(() => {
  loadMembers()
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
