<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click="closeModal">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Subscribe to {{ plan?.name }}</h3>
        <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <div v-if="!loading" class="space-y-4">
        <!-- Plan Details -->
        <div class="bg-gray-50 p-4 rounded-lg">
          <h4 class="font-medium text-gray-900">{{ plan?.name }} Plan</h4>
          <p class="text-sm text-gray-600 mb-2">{{ plan?.description }}</p>
          <div class="flex items-center justify-between">
            <span class="text-2xl font-bold text-gray-900">
              KES {{ formatPrice(selectedAmount) }}
            </span>
            <span class="text-sm text-gray-500">{{ billingCycle }}</span>
          </div>
          <div v-if="billingCycle === 'annual'" class="text-sm text-green-600 mt-1">
            Save 2 months with annual billing!
          </div>
        </div>

        <!-- Billing Cycle Selection -->
        <div>
          <label class="form-label">Billing Cycle</label>
          <div class="grid grid-cols-2 gap-3">
            <button
              @click="setBillingCycle('monthly')"
              :class="[
                'p-3 border rounded-lg text-center transition-colors',
                billingCycle === 'monthly' 
                  ? 'border-blueA bg-blue-50 text-blueA' 
                  : 'border-gray-300 hover:border-gray-400'
              ]"
            >
              <div class="font-medium">Monthly</div>
              <div class="text-sm text-gray-600">KES {{ formatPrice(monthlyPrice) }}/month</div>
            </button>
            <button
              @click="setBillingCycle('annual')"
              :class="[
                'p-3 border rounded-lg text-center transition-colors',
                billingCycle === 'annual' 
                  ? 'border-blueA bg-blue-50 text-blueA' 
                  : 'border-gray-300 hover:border-gray-400'
              ]"
            >
              <div class="font-medium">Annual</div>
              <div class="text-sm text-gray-600">KES {{ formatPrice(annualPrice) }}/year</div>
              <div class="text-xs text-green-600">Save 17%</div>
            </button>
          </div>
        </div>

        <!-- Payment Button -->
        <button
          @click="initiatePayment"
          :disabled="processing"
          class="w-full btn btn-primary py-3"
        >
          {{ processing ? 'Processing...' : `Pay KES ${formatPrice(selectedAmount)}` }}
        </button>

        <!-- Security Notice -->
        <div class="text-xs text-gray-500 text-center">
          <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
          </svg>
          Secure payment powered by Flutterwave
        </div>
      </div>

      <div v-else class="text-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blueA mx-auto"></div>
        <p class="mt-2 text-gray-600">Loading payment...</p>
      </div>

      <div v-if="error" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
        <p class="text-sm text-red-600">{{ error }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { http } from '@/api/http'

interface Plan {
  id: number
  name: string
  price_cents: number
  currency: string
  billing_cycle: string
  features: string[]
  description?: string
}

interface Props {
  show: boolean
  plan: Plan | null
}

interface Emits {
  (e: 'close'): void
  (e: 'success'): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emits>()

const authStore = useAuthStore()
const loading = ref(false)
const processing = ref(false)
const error = ref('')
const billingCycle = ref<'monthly' | 'annual'>('monthly')

const monthlyPrice = computed(() => props.plan ? props.plan.price_cents / 100 : 0)
const annualPrice = computed(() => monthlyPrice.value * 10) // 10 months price for annual
const selectedAmount = computed(() => billingCycle.value === 'annual' ? annualPrice.value : monthlyPrice.value)

const setBillingCycle = (cycle: 'monthly' | 'annual') => {
  billingCycle.value = cycle
}

const formatPrice = (amount: number) => {
  return new Intl.NumberFormat('en-KE').format(amount)
}

const closeModal = () => {
  if (!processing.value) {
    emit('close')
  }
}

const initiatePayment = async () => {
  if (!props.plan || !authStore.user) return

  processing.value = true
  error.value = ''

  try {
    const response = await http.post('/payments/initialize-subscription', {
      plan_id: props.plan.id,
      billing_cycle: billingCycle.value
    })

    if (response.data.success) {
      // Redirect to Flutterwave payment page
      window.location.href = response.data.payment_link
    } else {
      error.value = response.data.message || 'Payment initialization failed'
    }
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Payment initialization failed'
  } finally {
    processing.value = false
  }
}

// Reset state when modal opens/closes
watch(() => props.show, (newShow) => {
  if (newShow) {
    error.value = ''
    processing.value = false
    billingCycle.value = 'monthly'
  }
})
</script>
