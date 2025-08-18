<template>
  <div class="min-h-screen bg-gray-50">
    <div class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h1 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Membership</h1>
          <p class="text-xl text-gray-600">Select the plan that best fits your needs</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
          <!-- Free Plan -->
          <div class="card border-2 border-gray-200">
            <div class="text-center">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">Free</h3>
              <div class="text-4xl font-bold text-gray-900 mb-4">KES 0<span class="text-lg text-gray-500">/month</span></div>
              <ul class="text-left space-y-3 mb-8">
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Access to public announcements</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Limited event access</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Basic community features</li>
              </ul>
              <button @click="selectPlan(freePlan)" class="btn btn-outline w-full">Get Started</button>
            </div>
          </div>

          <!-- Individual Plan -->
          <div class="card border-2 border-blueA bg-blue-50">
            <div class="text-center">
              <div class="bg-blueA text-white px-3 py-1 rounded-full text-sm font-medium mb-4 inline-block">Most Popular</div>
              <h3 class="text-2xl font-bold text-gray-900 mb-2">Individual</h3>
              <div class="text-4xl font-bold text-gray-900 mb-4">KES 8,000<span class="text-lg text-gray-500">/month</span></div>
              <ul class="text-left space-y-3 mb-8">
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Full access to resources</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> All events and RSVP</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Member directory access</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Priority support</li>
              </ul>
              <button @click="selectPlan(individualPlan)" class="btn btn-primary w-full">Choose Plan</button>
            </div>
          </div>

          <!-- Institutional Plan -->
          <div class="card border-2 border-gray-200">
            <div class="text-center">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">Institutional</h3>
              <div class="text-4xl font-bold text-gray-900 mb-4">KES 35,000<span class="text-lg text-gray-500">/month</span></div>
              <ul class="text-left space-y-3 mb-8">
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Multi-seat access</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Analytics and reporting</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Priority event listings</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Dedicated support</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Custom branding options</li>
              </ul>
              <button @click="selectPlan(institutionalPlan)" class="btn btn-outline w-full">Contact Sales</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Modal -->
    <PaymentModal 
      :show="showPaymentModal" 
      :plan="selectedPlan" 
      @close="closePaymentModal"
      @success="onPaymentSuccess"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import PaymentModal from '@/components/PaymentModal.vue'

const router = useRouter()
const authStore = useAuthStore()

const showPaymentModal = ref(false)
const selectedPlan = ref(null)

// Mock plan data - in production this would come from API
const freePlan = {
  id: 1,
  name: 'Free',
  price_cents: 0,
  currency: 'KES',
  billing_cycle: 'monthly',
  features: ['Access to public announcements', 'Limited event access', 'Basic community features']
}

const individualPlan = {
  id: 2,
  name: 'Individual',
  price_cents: 800000, // 8000 KES in cents
  currency: 'KES',
  billing_cycle: 'monthly',
  features: ['Full access to resources', 'All events and RSVP', 'Member directory access', 'Priority support']
}

const institutionalPlan = {
  id: 3,
  name: 'Institutional',
  price_cents: 3500000, // 35000 KES in cents
  currency: 'KES',
  billing_cycle: 'monthly',
  features: ['Multi-seat access', 'Analytics and reporting', 'Priority event listings', 'Dedicated support', 'Custom branding options']
}

const selectPlan = (plan: any) => {
  if (!authStore.isAuthenticated) {
    router.push('/login?redirect=/membership')
    return
  }

  if (plan.id === 1) {
    // Free plan - redirect to register or dashboard
    router.push('/portal')
    return
  }

  selectedPlan.value = plan
  showPaymentModal.value = true
}

const closePaymentModal = () => {
  showPaymentModal.value = false
  selectedPlan.value = null
}

const onPaymentSuccess = () => {
  showPaymentModal.value = false
  selectedPlan.value = null
  router.push('/portal')
}
</script>
