<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Resource Library</h1>
        <p class="text-gray-600">Access exclusive resources for community members</p>
      </div>

      <!-- Filter Bar -->
      <div class="mb-6 flex flex-wrap gap-4">
        <select class="form-input w-auto">
          <option>All Categories</option>
          <option>Business</option>
          <option>Technology</option>
          <option>Finance</option>
          <option>Legal</option>
        </select>
        <select class="form-input w-auto">
          <option>All Types</option>
          <option>Document</option>
          <option>Video</option>
          <option>Link</option>
        </select>
        <input type="search" placeholder="Search resources..." class="form-input flex-1 max-w-md">
      </div>

      <!-- Resources Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card hover:shadow-lg transition-shadow">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-blueA rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Business</span>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Business Plan Template</h3>
          <p class="text-sm text-gray-600 mb-4">Comprehensive business plan template with financial projections</p>
          <button class="btn btn-sm btn-primary w-full">Download</button>
        </div>

        <div class="card hover:shadow-lg transition-shadow">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-blueB rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
            </div>
            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Video</span>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Digital Marketing Masterclass</h3>
          <p class="text-sm text-gray-600 mb-4">Learn modern digital marketing strategies from industry experts</p>
          <button class="btn btn-sm btn-primary w-full">Watch Now</button>
        </div>

        <div class="card hover:shadow-lg transition-shadow">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-aqua rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
              </svg>
            </div>
            <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">Link</span>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Industry Report 2025</h3>
          <p class="text-sm text-gray-600 mb-4">Latest trends and insights in African business landscape</p>
          <button class="btn btn-sm btn-primary w-full">View Report</button>
        </div>
      </div>
    </div>
  </div>
</template>
