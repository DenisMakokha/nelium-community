<template>
  <div class="min-h-screen bg-gray-50">
    <div class="py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-12">Contact Us</h1>
        <div class="grid md:grid-cols-2 gap-12">
          <div>
            <h2 class="text-2xl font-semibold mb-6">Get in Touch</h2>
            <div class="space-y-4">
              <div>
                <h3 class="font-medium text-gray-900">Email</h3>
                <p class="text-gray-600">{{ brand.footer.email }}</p>
              </div>
              <div>
                <h3 class="font-medium text-gray-900">Phone</h3>
                <p class="text-gray-600">{{ brand.footer.phone }}</p>
              </div>
            </div>
          </div>
          <div class="card">
            <h2 class="text-2xl font-semibold mb-6">Send us a message</h2>
            <form class="space-y-4">
              <div>
                <label class="form-label">Name</label>
                <input type="text" class="form-input" required>
              </div>
              <div>
                <label class="form-label">Email</label>
                <input type="email" class="form-input" required>
              </div>
              <div>
                <label class="form-label">Message</label>
                <textarea rows="4" class="form-input" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary w-full">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { brand } from '@/brand'
</script>
