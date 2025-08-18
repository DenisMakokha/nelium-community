<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Member Directory</h1>
        <p class="text-gray-600">Connect with fellow community members</p>
      </div>

      <!-- Search and Filter -->
      <div class="mb-6 flex flex-wrap gap-4">
        <input type="search" placeholder="Search members..." class="form-input flex-1 max-w-md">
        <select class="form-input w-auto">
          <option>All Countries</option>
          <option>Kenya</option>
          <option>Nigeria</option>
          <option>South Africa</option>
        </select>
        <select class="form-input w-auto">
          <option>All Industries</option>
          <option>Technology</option>
          <option>Finance</option>
          <option>Healthcare</option>
        </select>
      </div>

      <!-- Members Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card text-center">
          <div class="w-16 h-16 rounded-full bg-blueA flex items-center justify-center text-white text-lg font-bold mx-auto mb-4">
            JD
          </div>
          <h3 class="font-semibold text-gray-900">John Doe</h3>
          <p class="text-sm text-gray-600 mb-2">CEO, Tech Startup</p>
          <p class="text-xs text-gray-500 mb-4">Nairobi, Kenya</p>
          <button class="btn btn-sm btn-outline w-full">Connect</button>
        </div>
      </div>
    </div>
  </div>
</template>
