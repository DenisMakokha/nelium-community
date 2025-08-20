<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-50 to-primary-50">
    <PublicHeader />
    
    <main class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h1 class="text-4xl md:text-5xl font-heading font-bold text-navy-900 mb-6">Choose Your Membership</h1>
          <p class="text-xl text-navy-600 max-w-3xl mx-auto leading-relaxed">Select the plan that best fits your needs and unlock the full potential of our community platform.</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
          <!-- Free Plan -->
          <div class="bg-white rounded-2xl p-8 shadow-xl border-2 border-gray-200 hover:border-gray-300 transition-colors">
            <div class="text-center">
              <div class="w-16 h-16 bg-gradient-to-r from-gray-500 to-gray-600 rounded-xl flex items-center justify-center mb-6 mx-auto">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-heading font-bold text-navy-900 mb-2">Free</h3>
              <div class="text-4xl font-bold text-navy-900 mb-6">KES 0<span class="text-lg text-navy-500">/month</span></div>
              <ul class="text-left space-y-4 mb-8">
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Access to public announcements</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Limited event access</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Basic community features</li>
              </ul>
              <button @click="selectPlan(freePlan)" class="w-full px-6 py-3 border-2 border-navy-300 text-navy-700 rounded-xl font-semibold hover:bg-navy-50 transition-colors">
                Get Started
              </button>
            </div>
          </div>

          <!-- Individual Plan -->
          <div class="bg-white rounded-2xl p-8 shadow-xl border-2 border-primary-500 relative transform scale-105">
            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
              <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-2 rounded-full text-sm font-semibold shadow-lg">
                Most Popular
              </div>
            </div>
            <div class="text-center mt-4">
              <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center mb-6 mx-auto">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-heading font-bold text-navy-900 mb-2">Individual</h3>
              <div class="text-4xl font-bold text-navy-900 mb-6">KES 8,000<span class="text-lg text-navy-500">/month</span></div>
              <ul class="text-left space-y-4 mb-8">
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Full access to resources</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> All events and RSVP</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Member directory access</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Priority support</li>
              </ul>
              <button @click="selectPlan(individualPlan)" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 hover:scale-105 hover:shadow-lg">
                Choose Plan
              </button>
            </div>
          </div>

          <!-- Institutional Plan -->
          <div class="bg-white rounded-2xl p-8 shadow-xl border-2 border-gray-200 hover:border-gray-300 transition-colors">
            <div class="text-center">
              <div class="w-16 h-16 bg-gradient-to-r from-gold-500 to-gold-600 rounded-xl flex items-center justify-center mb-6 mx-auto">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-heading font-bold text-navy-900 mb-2">Institutional</h3>
              <div class="text-4xl font-bold text-navy-900 mb-6">KES 35,000<span class="text-lg text-navy-500">/month</span></div>
              <ul class="text-left space-y-4 mb-8">
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Multi-seat access</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Analytics and reporting</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Priority event listings</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Dedicated support</li>
                <li class="flex items-center"><span class="text-emerald-500 mr-3 text-lg">✓</span> Custom branding options</li>
              </ul>
              <button @click="selectPlan(institutionalPlan)" class="w-full px-6 py-3 border-2 border-navy-300 text-navy-700 rounded-xl font-semibold hover:bg-navy-50 transition-colors">
                Contact Sales
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
    
    <PublicFooter />

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
import PublicHeader from '@/components/layout/PublicHeader.vue'
import PublicFooter from '@/components/layout/PublicFooter.vue'
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
