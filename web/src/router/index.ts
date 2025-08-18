import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // Public routes
    {
      path: '/',
      name: 'home',
      component: () => import('@/views/public/Home.vue')
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('@/views/public/About.vue')
    },
    {
      path: '/membership',
      name: 'membership',
      component: () => import('@/views/public/Membership.vue')
    },
    {
      path: '/events',
      name: 'public-events',
      component: () => import('@/views/public/Events.vue')
    },
    {
      path: '/resources',
      name: 'public-resources',
      component: () => import('@/views/public/Resources.vue')
    },
    {
      path: '/blog',
      name: 'blog',
      component: () => import('@/views/public/Blog.vue')
    },
    {
      path: '/contact',
      name: 'contact',
      component: () => import('@/views/public/Contact.vue')
    },
    
    // Auth routes
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/auth/Login.vue'),
      meta: { guest: true }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('@/views/auth/Register.vue'),
      meta: { guest: true }
    },
    {
      path: '/verify-email',
      name: 'verify-email',
      component: () => import('@/views/auth/VerifyEmail.vue')
    },
    
    // Member portal routes
    {
      path: '/portal',
      name: 'portal',
      component: () => import('@/layouts/PortalLayout.vue'),
      meta: { requiresAuth: true },
      children: [
        {
          path: '',
          name: 'dashboard',
          component: () => import('@/views/portal/Dashboard.vue')
        },
        {
          path: 'resources',
          name: 'portal-resources',
          component: () => import('@/views/portal/Resources.vue')
        },
        {
          path: 'resources/:id',
          name: 'resource-detail',
          component: () => import('@/views/portal/ResourceDetail.vue')
        },
        {
          path: 'events',
          name: 'portal-events',
          component: () => import('@/views/portal/Events.vue')
        },
        {
          path: 'events/:slug',
          name: 'event-detail',
          component: () => import('@/views/portal/EventDetail.vue')
        },
        {
          path: 'directory',
          name: 'directory',
          component: () => import('@/views/portal/Directory.vue')
        },
        {
          path: 'profile',
          name: 'profile',
          component: () => import('@/views/portal/Profile.vue')
        },
        {
          path: 'billing',
          name: 'billing',
          component: () => import('@/views/portal/Billing.vue')
        },
        {
          path: 'billing/callback',
          name: 'payment-callback',
          component: () => import('@/views/portal/PaymentCallback.vue')
        }
      ]
    },
    
    // Admin routes
    {
      path: '/admin',
      name: 'admin',
      component: () => import('@/layouts/AdminLayout.vue'),
      meta: { requiresAuth: true, requiresAdmin: true },
      children: [
        {
          path: '',
          name: 'admin-dashboard',
          component: () => import('@/views/admin/Dashboard.vue')
        },
        {
          path: 'members',
          name: 'admin-members',
          component: () => import('@/views/admin/Members.vue')
        },
        {
          path: 'resources',
          name: 'admin-resources',
          component: () => import('@/views/admin/Resources.vue')
        },
        {
          path: 'events',
          name: 'admin-events',
          component: () => import('@/views/admin/Events.vue')
        },
        {
          path: 'payments',
          name: 'admin-payments',
          component: () => import('@/views/admin/Payments.vue')
        },
        {
          path: 'reports',
          name: 'admin-reports',
          component: () => import('@/views/admin/Reports.vue')
        },
        {
          path: 'announcements',
          name: 'admin-announcements',
          component: () => import('@/views/admin/Announcements.vue')
        }
      ]
    }
  ]
})

// Navigation guards
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()
  
  // Initialize auth state if not already done
  if (!authStore.initialized) {
    await authStore.initialize()
  }
  
  // Check if route requires authentication
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: 'login', query: { redirect: to.fullPath } })
    return
  }
  
  // Check if route requires admin access
  if (to.meta.requiresAdmin && !authStore.isAdmin) {
    next({ name: 'dashboard' })
    return
  }
  
  // Redirect authenticated users away from guest-only pages
  if (to.meta.guest && authStore.isAuthenticated) {
    next({ name: 'dashboard' })
    return
  }
  
  // Check email verification for protected routes
  if (to.meta.requiresAuth && authStore.isAuthenticated && !authStore.user?.email_verified_at) {
    next({ name: 'verify-email' })
    return
  }
  
  next()
})

export default router
