<template>
  <div class="min-h-screen bg-gray-50">
    <div class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-12">Resource Library</h1>
        <div class="text-center text-gray-600">
          <p>Access our comprehensive resource library. <RouterLink to="/login" class="text-blueA hover:underline">Login</RouterLink> to view member-exclusive content.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>
