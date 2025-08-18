<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm" role="navigation" aria-label="Main navigation">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <RouterLink to="/" class="text-xl font-bold text-navy">
              {{ brand.name }}
            </RouterLink>
          </div>
          <div class="flex items-center space-x-4">
            <RouterLink to="/about" class="nav-link">About</RouterLink>
            <RouterLink to="/membership" class="nav-link">Membership</RouterLink>
            <RouterLink to="/events" class="nav-link">Events</RouterLink>
            <RouterLink to="/resources" class="nav-link">Resources</RouterLink>
            <RouterLink to="/contact" class="nav-link">Contact</RouterLink>
            <RouterLink to="/login" class="btn btn-outline">Login</RouterLink>
            <RouterLink to="/register" class="btn btn-primary">Join Now</RouterLink>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content" class="flex-1">
      <!-- Hero Section -->
      <section class="bg-gradient-to-r from-navy to-blueA text-white py-20" aria-labelledby="hero-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h1 id="hero-heading" class="text-4xl md:text-6xl font-bold mb-6">
            Build Stronger Communities with Nelium
          </h1>
          <p class="text-xl md:text-2xl mb-8 text-blue-100">
            A secure, modern membership platform for networks and associations across Africa and beyond.
          </p>
          <RouterLink to="/register" class="btn bg-gold text-navy hover:bg-yellow-400 text-lg px-8 py-3">
            Join the Community
          </RouterLink>
        </div>
      </section>

      <!-- Features Section -->
      <section class="py-16" aria-labelledby="features-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 id="features-heading" class="text-3xl font-bold text-center text-gray-900 mb-12">
            Everything you need for your community
          </h2>
          <div class="grid md:grid-cols-3 gap-8">
            <div class="card text-center">
              <div class="w-12 h-12 bg-blueA rounded-lg mx-auto mb-4 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <h3 class="text-xl font-semibold mb-2">Member Management</h3>
              <p class="text-gray-600">Comprehensive member directory with privacy controls and tiered access.</p>
            </div>
            <div class="card text-center">
              <div class="w-12 h-12 bg-blueB rounded-lg mx-auto mb-4 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <h3 class="text-xl font-semibold mb-2">Events & RSVP</h3>
              <p class="text-gray-600">Organize events with RSVP management and automated reminders.</p>
            </div>
            <div class="card text-center">
              <div class="w-12 h-12 bg-aqua rounded-lg mx-auto mb-4 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <h3 class="text-xl font-semibold mb-2">Resource Library</h3>
              <p class="text-gray-600">Secure document sharing with tier-based access control.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="bg-gray-100 py-16" aria-labelledby="cta-heading">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
          <h2 id="cta-heading" class="text-3xl font-bold text-gray-900 mb-4">
            Ready to build your community?
          </h2>
          <p class="text-xl text-gray-600 mb-8">
            Join thousands of organizations using Nelium to connect and grow their communities.
          </p>
          <div class="space-x-4">
            <RouterLink to="/register" class="btn btn-primary text-lg px-8 py-3">
              Get Started Free
            </RouterLink>
            <RouterLink to="/membership" class="btn btn-outline text-lg px-8 py-3">
              View Plans
            </RouterLink>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="bg-navy text-white py-12" role="contentinfo">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8">
          <div>
            <h3 class="text-lg font-semibold mb-4">{{ brand.name }}</h3>
            <p class="text-blue-200">Building stronger communities across Africa and beyond.</p>
          </div>
          <div>
            <h4 class="font-semibold mb-4">Platform</h4>
            <ul class="space-y-2 text-blue-200">
              <li><RouterLink to="/membership" class="hover:text-white">Membership</RouterLink></li>
              <li><RouterLink to="/events" class="hover:text-white">Events</RouterLink></li>
              <li><RouterLink to="/resources" class="hover:text-white">Resources</RouterLink></li>
            </ul>
          </div>
          <div>
            <h4 class="font-semibold mb-4">Company</h4>
            <ul class="space-y-2 text-blue-200">
              <li><RouterLink to="/about" class="hover:text-white">About</RouterLink></li>
              <li><RouterLink to="/contact" class="hover:text-white">Contact</RouterLink></li>
              <li><RouterLink to="/blog" class="hover:text-white">Blog</RouterLink></li>
            </ul>
          </div>
          <div>
            <h4 class="font-semibold mb-4">Contact</h4>
            <p class="text-blue-200">{{ brand.footer.email }}</p>
            <p class="text-blue-200">{{ brand.footer.phone }}</p>
          </div>
        </div>
        <div class="border-t border-blue-800 mt-8 pt-8 text-center text-blue-200">
          <p>&copy; 2025 {{ brand.name }}. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { brand } from '@/brand'
</script>
