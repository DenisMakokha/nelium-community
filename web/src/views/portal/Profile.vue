<template>
  <div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
        <p class="text-gray-600">Manage your account information and preferences</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Form -->
        <div class="lg:col-span-2">
          <div class="card">
            <h2 class="text-xl font-semibold mb-6">Personal Information</h2>
            <form class="space-y-6" @submit.prevent="updateProfile">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="form-label">Full Name</label>
                  <input v-model="form.name" type="text" class="form-input" required>
                </div>
                <div>
                  <label class="form-label">Email</label>
                  <input v-model="form.email" type="email" class="form-input" required>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="form-label">Organization</label>
                  <input v-model="form.org" type="text" class="form-input">
                </div>
                <div>
                  <label class="form-label">Country</label>
                  <input v-model="form.country" type="text" class="form-input">
                </div>
              </div>
              <div>
                <label class="form-label">Profession</label>
                <input v-model="form.profession" type="text" class="form-input">
              </div>
              <div>
                <label class="form-label">Bio</label>
                <textarea v-model="form.bio" rows="4" class="form-input"></textarea>
              </div>
              <div class="flex items-center">
                <input v-model="form.privacy_opt_out" type="checkbox" class="h-4 w-4 text-blueA">
                <label class="ml-2 text-sm text-gray-700">Hide my profile from member directory</label>
              </div>
              <button type="submit" :disabled="loading" class="btn btn-primary">
                {{ loading ? 'Updating...' : 'Update Profile' }}
              </button>
            </form>
          </div>
        </div>

        <!-- Avatar & Stats -->
        <div class="space-y-6">
          <div class="card text-center">
            <div class="w-24 h-24 rounded-full bg-blueA flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
              {{ authStore.user?.name?.charAt(0) || 'U' }}
            </div>
            <h3 class="font-semibold text-gray-900">{{ authStore.user?.name }}</h3>
            <p class="text-sm text-gray-600">{{ authStore.user?.org }}</p>
            <button class="btn btn-sm btn-outline mt-4">Change Avatar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const form = ref({
  name: '',
  email: '',
  org: '',
  country: '',
  profession: '',
  bio: '',
  privacy_opt_out: false
})

const loading = ref(false)

const updateProfile = async () => {
  loading.value = true
  try {
    await authStore.updateProfile(form.value)
  } catch (error) {
    console.error('Profile update failed:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  if (authStore.user) {
    form.value = {
      name: authStore.user.name || '',
      email: authStore.user.email || '',
      org: authStore.user.org || '',
      country: authStore.user.country || '',
      profession: authStore.user.profession || '',
      bio: authStore.user.bio || '',
      privacy_opt_out: authStore.user.privacy_opt_out || false
    }
  }
})
</script>
