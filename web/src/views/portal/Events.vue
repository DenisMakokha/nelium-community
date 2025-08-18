<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Community Events</h1>
        <p class="text-gray-600">Discover and join upcoming community events</p>
      </div>

      <!-- Filter Bar -->
      <div class="mb-6 flex flex-wrap gap-4">
        <select class="form-input w-auto">
          <option>All Events</option>
          <option>This Week</option>
          <option>This Month</option>
          <option>Virtual</option>
          <option>In-Person</option>
        </select>
        <input type="search" placeholder="Search events..." class="form-input flex-1 max-w-md">
      </div>

      <!-- Events List -->
      <div class="space-y-6">
        <div class="card hover:shadow-lg transition-shadow">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center mb-2">
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full mr-2">Virtual</span>
                <span class="text-sm text-gray-500">Jan 25, 2025 • 6:00 PM EAT</span>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Monthly Networking Mixer</h3>
              <p class="text-gray-600 mb-4">Join fellow entrepreneurs for an evening of networking and collaboration. Share ideas, make connections, and grow your business network.</p>
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                45 attending
              </div>
            </div>
            <div class="ml-6 flex flex-col space-y-2">
              <button class="btn btn-primary">RSVP</button>
              <RouterLink to="/portal/events/monthly-networking-mixer" class="btn btn-outline">View Details</RouterLink>
            </div>
          </div>
        </div>

        <div class="card hover:shadow-lg transition-shadow">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center mb-2">
                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full mr-2">Workshop</span>
                <span class="text-sm text-gray-500">Feb 2, 2025 • 2:00 PM EAT</span>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Business Growth Workshop</h3>
              <p class="text-gray-600 mb-4">Learn proven strategies for scaling your business in the African market. Expert speakers will share insights on funding, marketing, and operations.</p>
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Nairobi, Kenya
              </div>
            </div>
            <div class="ml-6 flex flex-col space-y-2">
              <button class="btn btn-outline">RSVP</button>
              <RouterLink to="/portal/events/business-growth-workshop" class="btn btn-outline">View Details</RouterLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>
