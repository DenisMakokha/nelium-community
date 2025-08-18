<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ authStore.user?.name }}</h1>
        <p class="text-gray-600">Here's what's happening in your community</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-blueA rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Upcoming Events</p>
              <p class="text-2xl font-semibold text-gray-900">3</p>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-blueB rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">New Resources</p>
              <p class="text-2xl font-semibold text-gray-900">12</p>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-aqua rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Active Members</p>
              <p class="text-2xl font-semibold text-gray-900">1,247</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="card">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Announcements</h3>
          <div class="space-y-4">
            <div class="border-l-4 border-blueA pl-4">
              <h4 class="font-medium text-gray-900">Welcome to Q1 2025</h4>
              <p class="text-sm text-gray-600">New year, new opportunities! Check out our upcoming events...</p>
              <p class="text-xs text-gray-500 mt-1">2 days ago</p>
            </div>
            <div class="border-l-4 border-blueB pl-4">
              <h4 class="font-medium text-gray-900">Resource Library Update</h4>
              <p class="text-sm text-gray-600">We've added 15 new resources to help you grow your business...</p>
              <p class="text-xs text-gray-500 mt-1">1 week ago</p>
            </div>
          </div>
        </div>

        <div class="card">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Events</h3>
          <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div>
                <h4 class="font-medium text-gray-900">Monthly Networking Mixer</h4>
                <p class="text-sm text-gray-600">Jan 25, 2025 • 6:00 PM</p>
              </div>
              <button class="btn btn-sm btn-primary">RSVP</button>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div>
                <h4 class="font-medium text-gray-900">Business Growth Workshop</h4>
                <p class="text-sm text-gray-600">Feb 2, 2025 • 2:00 PM</p>
              </div>
              <button class="btn btn-sm btn-outline">RSVP</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>
