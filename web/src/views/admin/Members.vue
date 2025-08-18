<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8 flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-white">Members</h1>
          <p class="text-blue-200">Manage community members ({{ membersData?.total || 0 }} total)</p>
        </div>
        <button @click="showAddModal = true" class="btn bg-white text-navy hover:bg-gray-100">Add Member</button>
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
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="member in membersData.data" :key="member.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="h-10 w-10 rounded-full bg-blueA text-white flex items-center justify-center text-sm font-medium">
                    {{ getInitials(member.name) }}
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ member.name }}</div>
                    <div class="text-sm text-gray-500">{{ member.email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                  {{ member.subscription?.plan?.name || 'No Plan' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(member.subscription?.status || 'inactive')" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                  {{ member.subscription?.status || 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(member.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button @click="editMember(member)" class="text-blueA hover:text-blue-900 mr-3">Edit</button>
                <button @click="suspendMember(member)" class="text-yellow-600 hover:text-yellow-900 mr-3">Suspend</button>
                <button @click="deleteMember(member)" class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
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
import { ref, onMounted, reactive } from 'vue'
import { adminService, type Member } from '@/services/adminService'
import { debounce } from 'lodash-es'

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
      return 'bg-green-100 text-green-800'
    case 'cancelled':
    case 'inactive':
      return 'bg-red-100 text-red-800'
    case 'pending':
      return 'bg-yellow-100 text-yellow-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
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
