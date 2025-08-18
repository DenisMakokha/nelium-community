<template>
  <div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-6">
        <RouterLink to="/portal/events" class="text-blueA hover:underline">
          ← Back to Events
        </RouterLink>
      </div>
      
      <div class="card">
        <div class="flex items-center mb-4">
          <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full mr-2">Virtual</span>
          <span class="text-sm text-gray-500">Jan 25, 2025 • 6:00 PM EAT</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Event Title</h1>
        <div class="prose max-w-none mb-6">
          <p>Event description and details will be loaded here...</p>
        </div>
        <div class="flex space-x-4">
          <button class="btn btn-primary">RSVP</button>
          <button class="btn btn-outline">Add to Calendar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>
