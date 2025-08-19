<template>
  <div class="animate-pulse">
    <!-- Card Skeleton -->
    <div v-if="type === 'card'" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
      <div class="flex items-center space-x-3">
        <div class="w-12 h-12 bg-gray-200 rounded-xl"></div>
        <div class="flex-1">
          <div class="h-4 bg-gray-200 rounded w-24 mb-2"></div>
          <div class="h-8 bg-gray-200 rounded w-16"></div>
        </div>
      </div>
    </div>

    <!-- Table Row Skeleton -->
    <tr v-else-if="type === 'table-row'" class="border-b border-gray-100">
      <td class="px-6 py-4">
        <div class="flex items-center">
          <div class="w-9 h-9 bg-gray-200 rounded-lg"></div>
          <div class="ml-3">
            <div class="h-4 bg-gray-200 rounded w-32 mb-1"></div>
            <div class="h-3 bg-gray-200 rounded w-24"></div>
          </div>
        </div>
      </td>
      <td class="px-6 py-4">
        <div class="h-4 bg-gray-200 rounded w-24 mb-1"></div>
        <div class="h-3 bg-gray-200 rounded w-32"></div>
      </td>
      <td class="px-6 py-4">
        <div class="h-4 bg-gray-200 rounded w-16"></div>
      </td>
      <td class="px-6 py-4">
        <div class="h-6 bg-gray-200 rounded-full w-20"></div>
      </td>
      <td class="px-6 py-4">
        <div class="h-4 bg-gray-200 rounded w-20 mb-1"></div>
        <div class="h-3 bg-gray-200 rounded w-16"></div>
      </td>
      <td class="px-6 py-4 text-right">
        <div class="flex justify-end space-x-2">
          <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
          <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
          <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
        </div>
      </td>
    </tr>

    <!-- List Item Skeleton -->
    <div v-else-if="type === 'list-item'" class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
          <div>
            <div class="h-4 bg-gray-200 rounded w-32 mb-1"></div>
            <div class="h-3 bg-gray-200 rounded w-24"></div>
          </div>
        </div>
        <div class="h-6 bg-gray-200 rounded w-16"></div>
      </div>
    </div>

    <!-- Member Card Skeleton -->
    <div v-else-if="type === 'member-card'" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
      <div class="text-center">
        <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-4"></div>
        <div class="h-5 bg-gray-200 rounded w-24 mx-auto mb-2"></div>
        <div class="h-4 bg-gray-200 rounded w-32 mx-auto mb-2"></div>
        <div class="h-3 bg-gray-200 rounded w-20 mx-auto mb-4"></div>
        <div class="h-8 bg-gray-200 rounded w-full"></div>
      </div>
    </div>

    <!-- Payment Card Skeleton -->
    <tr v-else-if="type === 'payment-row'" class="border-b border-gray-100">
      <td class="px-6 py-4">
        <div class="flex items-center">
          <div class="w-10 h-10 bg-gray-200 rounded-xl"></div>
          <div class="ml-3">
            <div class="h-4 bg-gray-200 rounded w-20 mb-1"></div>
            <div class="h-3 bg-gray-200 rounded w-16"></div>
          </div>
        </div>
      </td>
      <td class="px-6 py-4">
        <div class="flex items-center">
          <div class="w-9 h-9 bg-gray-200 rounded-lg"></div>
          <div class="ml-3">
            <div class="h-4 bg-gray-200 rounded w-28 mb-1"></div>
            <div class="h-3 bg-gray-200 rounded w-36"></div>
          </div>
        </div>
      </td>
      <td class="px-6 py-4">
        <div class="h-5 bg-gray-200 rounded w-16 mb-1"></div>
        <div class="h-3 bg-gray-200 rounded w-10"></div>
      </td>
      <td class="px-6 py-4">
        <div class="h-6 bg-gray-200 rounded-full w-24"></div>
      </td>
      <td class="px-6 py-4">
        <div class="h-4 bg-gray-200 rounded w-20 mb-1"></div>
        <div class="h-3 bg-gray-200 rounded w-16"></div>
      </td>
      <td class="px-6 py-4 text-right">
        <div class="flex justify-end space-x-2">
          <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
          <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
        </div>
      </td>
    </tr>

    <!-- Generic Skeleton -->
    <div v-else class="space-y-3">
      <div class="h-4 bg-gray-200 rounded w-3/4"></div>
      <div class="h-4 bg-gray-200 rounded w-1/2"></div>
      <div class="h-4 bg-gray-200 rounded w-5/6"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  type?: 'card' | 'table-row' | 'list-item' | 'member-card' | 'payment-row' | 'generic'
}

withDefaults(defineProps<Props>(), {
  type: 'generic'
})
</script>
