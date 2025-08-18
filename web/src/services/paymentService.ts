import { http } from '@/api/http'

export interface PaymentConfig {
  public_key: string
  currency: string
  frontend_url: string
}

export interface Plan {
  id: number
  name: string
  price_cents: number
  currency: string
  billing_cycle: string
  features: string[]
}

export interface InitializePaymentRequest {
  plan_id: number
  billing_cycle: 'monthly' | 'annual'
}

export interface InitializePaymentResponse {
  success: boolean
  payment_link: string
  tx_ref: string
  message?: string
}

export interface VerifyPaymentRequest {
  transaction_id: string
  tx_ref: string
}

export interface VerifyPaymentResponse {
  success: boolean
  message?: string
  subscription?: {
    id: number
    status: string
    plan: Plan
  }
}

export class PaymentService {
  static async getConfig(): Promise<PaymentConfig> {
    const response = await http.get('/payments/config')
    return response.data
  }

  static async initializeSubscription(data: InitializePaymentRequest): Promise<InitializePaymentResponse> {
    const response = await http.post('/payments/initialize-subscription', data)
    return response.data
  }

  static async verifyPayment(data: VerifyPaymentRequest): Promise<VerifyPaymentResponse> {
    const response = await http.post('/payments/verify', data)
    return response.data
  }

  static async cancelSubscription(): Promise<{ success: boolean; message?: string }> {
    const response = await http.post('/payments/cancel-subscription')
    return response.data
  }

  static async upgradeSubscription(data: InitializePaymentRequest): Promise<InitializePaymentResponse> {
    const response = await http.post('/payments/upgrade-subscription', data)
    return response.data
  }

  static async getPaymentHistory(): Promise<{
    success: boolean
    payments: {
      data: Array<{
        id: number
        amount_cents: number
        currency: string
        status: string
        created_at: string
        subscription: {
          plan: Plan
        }
      }>
    }
  }> {
    const response = await http.get('/payments/history')
    return response.data
  }

  static async getSubscriptionStatus(): Promise<{
    has_subscription: boolean
    plan?: Plan
    status?: string
    current_period_end?: string
  }> {
    const response = await http.get('/payments/subscription-status')
    return response.data
  }
}
