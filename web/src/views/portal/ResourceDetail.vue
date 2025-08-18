<template>
  <div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-6">
        <RouterLink to="/portal/resources" class="text-blueA hover:underline">
          ← Back to Resources
        </RouterLink>
      </div>
      
      <div class="card">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Resource Title</h1>
        <div class="flex items-center space-x-4 mb-6">
          <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Business</span>
          <span class="text-sm text-gray-500">Published on Jan 15, 2025</span>
        </div>
        <div class="prose max-w-none">
          <p>Resource content will be loaded here...</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>
