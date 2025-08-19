<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transform ease-out duration-300 transition"
      enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
      enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="visible"
        class="fixed top-4 right-4 z-50 max-w-sm w-full mx-4 sm:mx-0 bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
      >
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <!-- Success Icon -->
              <div v-if="type === 'success'" class="w-6 h-6 text-green-400">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              
              <!-- Error Icon -->
              <div v-else-if="type === 'error'" class="w-6 h-6 text-red-400">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              
              <!-- Warning Icon -->
              <div v-else-if="type === 'warning'" class="w-6 h-6 text-yellow-400">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
              </div>
              
              <!-- Info Icon -->
              <div v-else class="w-6 h-6 text-blue-400">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p v-if="title" class="text-sm font-medium text-gray-900">{{ title }}</p>
              <p class="text-sm text-gray-500" :class="{ 'mt-1': title }">{{ message }}</p>
            </div>
            
            <div class="ml-4 flex-shrink-0 flex">
              <button
                @click="close"
                class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
              >
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        
        <!-- Progress bar for auto-dismiss -->
        <div v-if="autoDismiss && duration" class="h-1 bg-gray-200">
          <div 
            class="h-full transition-all ease-linear"
            :class="progressBarClass"
            :style="{ width: progressWidth + '%' }"
          ></div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'

interface Props {
  type?: 'success' | 'error' | 'warning' | 'info'
  title?: string
  message: string
  autoDismiss?: boolean
  duration?: number
}

const props = withDefaults(defineProps<Props>(), {
  type: 'info',
  autoDismiss: true,
  duration: 5000
})

const emit = defineEmits<{
  close: []
}>()

const visible = ref(true)
const progressWidth = ref(100)
let dismissTimer: NodeJS.Timeout | null = null
let progressTimer: NodeJS.Timeout | null = null

const progressBarClass = computed(() => {
  switch (props.type) {
    case 'success':
      return 'bg-green-500'
    case 'error':
      return 'bg-red-500'
    case 'warning':
      return 'bg-yellow-500'
    default:
      return 'bg-blue-500'
  }
})

const close = () => {
  visible.value = false
  if (dismissTimer) clearTimeout(dismissTimer)
  if (progressTimer) clearInterval(progressTimer)
  setTimeout(() => emit('close'), 100)
}

onMounted(() => {
  if (props.autoDismiss && props.duration) {
    // Auto dismiss timer
    dismissTimer = setTimeout(close, props.duration)
    
    // Progress bar animation
    const interval = 50
    const steps = props.duration / interval
    const decrement = 100 / steps
    
    progressTimer = setInterval(() => {
      progressWidth.value -= decrement
      if (progressWidth.value <= 0) {
        progressWidth.value = 0
        if (progressTimer) clearInterval(progressTimer)
      }
    }, interval)
  }
})

onUnmounted(() => {
  if (dismissTimer) clearTimeout(dismissTimer)
  if (progressTimer) clearInterval(progressTimer)
})
</script>
