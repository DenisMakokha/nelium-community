<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Member Directory</h1>
        <p class="text-gray-600">Connect with fellow community members</p>
      </div>

      <!-- Search and Filter -->
      <div class="mb-6 flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
        <input type="search" placeholder="Search members..." class="form-input flex-1 w-full sm:max-w-md">
        <select class="form-input w-full sm:w-auto">
          <option>All Countries</option>
          <option>Kenya</option>
          <option>Nigeria</option>
          <option>South Africa</option>
        </select>
        <select class="form-input w-full sm:w-auto">
          <option>All Industries</option>
          <option>Technology</option>
          <option>Finance</option>
          <option>Healthcare</option>
        </select>
      </div>

      <!-- Members Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-lg hover:border-primary-200 transition-all duration-300 group">
          <div class="w-16 h-16 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white text-lg font-bold mx-auto mb-4 group-hover:scale-105 transition-transform">
            JD
          </div>
          <h3 class="font-semibold text-navy-900 mb-1">John Doe</h3>
          <p class="text-sm text-navy-600 mb-2">CEO, Tech Startup</p>
          <p class="text-xs text-navy-500 mb-4 flex items-center justify-center">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Nairobi, Kenya
          </p>
          <button class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
            Connect
          </button>
        </div>
        
        <!-- Additional sample members -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-lg hover:border-primary-200 transition-all duration-300 group">
          <div class="w-16 h-16 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-lg font-bold mx-auto mb-4 group-hover:scale-105 transition-transform">
            AS
          </div>
          <h3 class="font-semibold text-navy-900 mb-1">Amina Suleiman</h3>
          <p class="text-sm text-navy-600 mb-2">Financial Analyst</p>
          <p class="text-xs text-navy-500 mb-4 flex items-center justify-center">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Lagos, Nigeria
          </p>
          <button class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
            Connect
          </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-lg hover:border-primary-200 transition-all duration-300 group">
          <div class="w-16 h-16 rounded-full bg-gradient-to-r from-gold-500 to-gold-600 flex items-center justify-center text-white text-lg font-bold mx-auto mb-4 group-hover:scale-105 transition-transform">
            MK
          </div>
          <h3 class="font-semibold text-navy-900 mb-1">Michael Kiptoo</h3>
          <p class="text-sm text-navy-600 mb-2">Software Engineer</p>
          <p class="text-xs text-navy-500 mb-4 flex items-center justify-center">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Eldoret, Kenya
          </p>
          <button class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-md">
            Connect
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
