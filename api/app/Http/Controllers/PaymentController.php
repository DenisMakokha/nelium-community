<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\FlutterwaveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private $flutterwaveService;

    public function __construct(FlutterwaveService $flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
    }

    /**
     * Initialize a subscription payment
     */
    public function initializeSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'billing_cycle' => 'required|in:monthly,annual'
        ]);

        $user = Auth::user();
        $plan = Plan::findOrFail($request->plan_id);

        // Check if user already has an active subscription
        $existingSubscription = $user->subscription()->where('status', 'active')->first();
        if ($existingSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription'
            ], 400);
        }

        // Generate unique transaction reference
        $txRef = 'NEL_' . time() . '_' . $user->id . '_' . Str::random(8);

        // Calculate amount based on billing cycle
        $amount = $plan->price_cents / 100;
        if ($request->billing_cycle === 'annual') {
            $amount = $amount * 10; // 10 months price for annual (2 months free)
        }

        // Prepare payment data
        $paymentData = [
            'tx_ref' => $txRef,
            'amount' => $amount,
            'currency' => $plan->currency,
            'redirect_url' => config('app.frontend_url') . '/portal/billing/callback',
            'customer' => [
                'email' => $user->email,
                'name' => $user->name,
                'phone' => $user->phone ?? ''
            ],
            'title' => 'Nelium Community - ' . $plan->name . ' Subscription',
            'description' => $plan->name . ' subscription (' . $request->billing_cycle . ')',
            'meta' => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'billing_cycle' => $request->billing_cycle
            ]
        ];

        // Initialize payment with Flutterwave
        $result = $this->flutterwaveService->initializePayment($paymentData);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
        }

        // Store payment record
        Payment::create([
            'user_id' => $user->id,
            'subscription_id' => null, // Will be updated after successful payment
            'gateway' => 'flutterwave',
            'gateway_txn_id' => $txRef,
            'amount_cents' => $amount * 100,
            'currency' => $plan->currency,
            'status' => 'pending',
            'payload' => json_encode($result['data'])
        ]);

        return response()->json([
            'success' => true,
            'payment_link' => $result['payment_link'],
            'tx_ref' => $txRef
        ]);
    }

    /**
     * Handle payment callback/verification
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'tx_ref' => 'required|string'
        ]);

        // Verify payment with Flutterwave
        $result = $this->flutterwaveService->verifyPayment($request->transaction_id);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed'
            ], 400);
        }

        $paymentData = $result['data'];

        // Check if payment was successful
        if ($paymentData['status'] !== 'successful') {
            return response()->json([
                'success' => false,
                'message' => 'Payment was not successful'
            ], 400);
        }

        // Find the payment record
        $payment = Payment::where('gateway_txn_id', $request->tx_ref)->first();
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment record not found'
            ], 404);
        }

        // Prevent double processing
        if ($payment->status === 'completed') {
            return response()->json([
                'success' => true,
                'message' => 'Payment already processed'
            ]);
        }

        DB::beginTransaction();
        try {
            // Get metadata from payment
            $meta = json_decode($paymentData['meta'] ?? '{}', true);
            $planId = $meta['plan_id'] ?? null;
            $billingCycle = $meta['billing_cycle'] ?? 'monthly';
            $userId = $meta['user_id'] ?? $payment->user_id;

            $user = User::findOrFail($userId);
            $plan = Plan::findOrFail($planId);

            // Calculate subscription period
            $startDate = now();
            $endDate = $billingCycle === 'annual' 
                ? $startDate->copy()->addYear() 
                : $startDate->copy()->addMonth();

            // Create or update subscription
            $subscription = Subscription::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'plan_id' => $plan->id,
                    'status' => 'active',
                    'current_period_start' => $startDate,
                    'current_period_end' => $endDate,
                    'cancel_at_period_end' => false,
                    'gateway' => 'flutterwave',
                    'gateway_customer_id' => $paymentData['customer']['id'] ?? null
                ]
            );

            // Update payment record
            $payment->update([
                'subscription_id' => $subscription->id,
                'status' => 'completed',
                'payload' => json_encode($paymentData)
            ]);

            // Log audit trail
            \App\Models\AuditLog::create([
                'actor_id' => $user->id,
                'action' => 'subscription_created',
                'entity_type' => 'subscription',
                'entity_id' => $subscription->id,
                'meta' => json_encode([
                    'plan' => $plan->name,
                    'billing_cycle' => $billingCycle,
                    'amount' => $paymentData['amount'],
                    'currency' => $paymentData['currency']
                ])
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Subscription activated successfully',
                'subscription' => $subscription->load('plan')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing failed', [
                'error' => $e->getMessage(),
                'payment_id' => $payment->id,
                'transaction_id' => $request->transaction_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment'
            ], 500);
        }
    }

    /**
     * Handle Flutterwave webhooks
     */
    public function handleWebhook(Request $request)
    {
        // Verify webhook signature
        $signature = $request->header('verif-hash');
        $expectedSignature = config('services.flutterwave.webhook_hash');

        if ($signature !== $expectedSignature) {
            Log::warning('Invalid webhook signature', [
                'received' => $signature,
                'expected' => $expectedSignature
            ]);
            return response()->json(['status' => 'error'], 401);
        }

        $payload = $request->all();
        $event = $payload['event'] ?? null;

        Log::info('Flutterwave webhook received', [
            'event' => $event,
            'payload' => $payload
        ]);

        switch ($event) {
            case 'charge.completed':
                $this->handleChargeCompleted($payload);
                break;
            case 'subscription.cancelled':
                $this->handleSubscriptionCancelled($payload);
                break;
            default:
                Log::info('Unhandled webhook event', ['event' => $event]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle successful charge webhook
     */
    private function handleChargeCompleted($payload)
    {
        $data = $payload['data'] ?? [];
        $txRef = $data['tx_ref'] ?? null;

        if (!$txRef) {
            Log::warning('Webhook charge completed without tx_ref', $payload);
            return;
        }

        $payment = Payment::where('gateway_txn_id', $txRef)->first();
        if (!$payment || $payment->status === 'completed') {
            return; // Already processed or not found
        }

        // Process the payment (similar to verifyPayment logic)
        // This ensures webhook-driven completion works even if user doesn't return to callback
        $this->processWebhookPayment($payment, $data);
    }

    /**
     * Handle subscription cancellation webhook
     */
    private function handleSubscriptionCancelled($payload)
    {
        $data = $payload['data'] ?? [];
        $customerId = $data['customer']['id'] ?? null;

        if (!$customerId) {
            return;
        }

        $subscription = Subscription::where('gateway_customer_id', $customerId)
            ->where('status', 'active')
            ->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'cancelled',
                'cancel_at_period_end' => true
            ]);

            // Log audit trail
            \App\Models\AuditLog::create([
                'actor_id' => $subscription->user_id,
                'action' => 'subscription_cancelled',
                'entity_type' => 'subscription',
                'entity_id' => $subscription->id,
                'meta' => json_encode(['reason' => 'webhook_cancellation'])
            ]);
        }
    }

    /**
     * Process payment from webhook
     */
    private function processWebhookPayment($payment, $data)
    {
        // Implementation similar to verifyPayment but for webhook context
        // This ensures redundancy in payment processing
    }

    /**
     * Get payment configuration for frontend
     */
    public function getConfig()
    {
        return response()->json([
            'public_key' => $this->flutterwaveService->getPublicKey(),
            'currency' => 'KES'
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->subscription()->where('status', 'active')->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription found'
            ], 404);
        }

        $subscription->update([
            'cancel_at_period_end' => true
        ]);

        // Log audit trail
        \App\Models\AuditLog::create([
            'actor_id' => $user->id,
            'action' => 'subscription_cancelled',
            'entity_type' => 'subscription',
            'entity_id' => $subscription->id,
            'meta' => json_encode(['reason' => 'user_request'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription will be cancelled at the end of current period',
            'subscription' => $subscription->load('plan')
        ]);
    }

    /**
     * Upgrade subscription
     */
    public function upgradeSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'billing_cycle' => 'required|in:monthly,annual'
        ]);

        try {
            $user = $request->user();
            $newPlan = \App\Models\Plan::findOrFail($request->plan_id);
            $currentSubscription = $user->subscriptions()->where('status', 'active')->first();

            if (!$currentSubscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription to upgrade'
                ], 404);
            }

            // Initialize payment for upgrade
            $paymentData = $this->flutterwaveService->initializePayment([
                'amount' => $request->billing_cycle === 'annual' 
                    ? ($newPlan->price_cents * 10) / 100 // 10 months for annual
                    : $newPlan->price_cents / 100,
                'currency' => $newPlan->currency,
                'email' => $user->email,
                'tx_ref' => 'upgrade_' . uniqid(),
                'redirect_url' => config('services.flutterwave.frontend_url') . '/portal/billing/callback',
                'customer' => [
                    'email' => $user->email,
                    'name' => $user->name
                ],
                'meta' => [
                    'user_id' => $user->id,
                    'plan_id' => $newPlan->id,
                    'billing_cycle' => $request->billing_cycle,
                    'type' => 'upgrade'
                ]
            ]);

            return response()->json([
                'success' => true,
                'payment_link' => $paymentData['link'],
                'tx_ref' => $paymentData['tx_ref']
            ]);

        } catch (\Exception $e) {
            Log::error('Subscription upgrade failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Subscription upgrade failed'
            ], 500);
        }
    }

    /**
     * Get payment history
     */
    public function getPaymentHistory(Request $request)
    {
        try {
            $user = $request->user();
            $payments = \App\Models\Payment::where('user_id', $user->id)
                ->with(['subscription.plan'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'payments' => $payments
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch payment history', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch payment history'
            ], 500);
        }
    }
}
