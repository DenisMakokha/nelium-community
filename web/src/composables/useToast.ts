import { ref, createApp } from 'vue'
import ToastNotification from '@/components/ToastNotification.vue'

interface ToastOptions {
  type?: 'success' | 'error' | 'warning' | 'info'
  title?: string
  message: string
  autoDismiss?: boolean
  duration?: number
}

const toasts = ref<Array<{ id: number; component: any }>>([])
let toastId = 0

export const useToast = () => {
  const show = (options: ToastOptions) => {
    const id = ++toastId
    
    // Create a container for this toast
    const container = document.createElement('div')
    container.id = `toast-${id}`
    document.body.appendChild(container)
    
    // Create the toast component
    const app = createApp(ToastNotification, {
      ...options,
      onClose: () => {
        // Remove the toast and clean up
        app.unmount()
        document.body.removeChild(container)
        toasts.value = toasts.value.filter(toast => toast.id !== id)
      }
    })
    
    // Mount the component
    app.mount(container)
    
    // Track the toast
    toasts.value.push({ id, component: app })
    
    return id
  }
  
  const success = (message: string, title?: string) => {
    return show({ type: 'success', message, title })
  }
  
  const error = (message: string, title?: string) => {
    return show({ type: 'error', message, title })
  }
  
  const warning = (message: string, title?: string) => {
    return show({ type: 'warning', message, title })
  }
  
  const info = (message: string, title?: string) => {
    return show({ type: 'info', message, title })
  }
  
  const dismiss = (id: number) => {
    const toast = toasts.value.find(t => t.id === id)
    if (toast) {
      // Trigger close on the component
      const container = document.getElementById(`toast-${id}`)
      if (container) {
        container.dispatchEvent(new CustomEvent('close'))
      }
    }
  }
  
  const dismissAll = () => {
    toasts.value.forEach(toast => dismiss(toast.id))
  }
  
  return {
    show,
    success,
    error,
    warning,
    info,
    dismiss,
    dismissAll,
    toasts: toasts.value
  }
}
