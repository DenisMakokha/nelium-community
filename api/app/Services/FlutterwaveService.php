<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FlutterwaveService
{
    private $client;
    private $secretKey;
    private $publicKey;
    private $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->secretKey = config('services.flutterwave.secret_key');
        $this->publicKey = config('services.flutterwave.public_key');
        $this->baseUrl = config('services.flutterwave.base_url', 'https://api.flutterwave.com/v3');
    }

    /**
     * Initialize a payment transaction
     */
    public function initializePayment(array $paymentData)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/payments', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'tx_ref' => $paymentData['tx_ref'],
                    'amount' => $paymentData['amount'],
                    'currency' => $paymentData['currency'] ?? 'KES',
                    'redirect_url' => $paymentData['redirect_url'],
                    'payment_options' => 'card,mobilemoney,ussd',
                    'customer' => [
                        'email' => $paymentData['customer']['email'],
                        'phonenumber' => $paymentData['customer']['phone'] ?? '',
                        'name' => $paymentData['customer']['name'],
                    ],
                    'customizations' => [
                        'title' => $paymentData['title'] ?? 'Nelium Community Subscription',
                        'description' => $paymentData['description'] ?? 'Subscription payment',
                        'logo' => config('app.url') . '/logo.png',
                    ],
                    'meta' => $paymentData['meta'] ?? [],
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            
            if ($body['status'] === 'success') {
                return [
                    'success' => true,
                    'data' => $body['data'],
                    'payment_link' => $body['data']['link']
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? 'Payment initialization failed'
            ];

        } catch (RequestException $e) {
            Log::error('Flutterwave payment initialization failed', [
                'error' => $e->getMessage(),
                'payment_data' => $paymentData
            ]);

            return [
                'success' => false,
                'message' => 'Payment service unavailable'
            ];
        }
    }

    /**
     * Verify a payment transaction
     */
    public function verifyPayment($transactionId)
    {
        try {
            $response = $this->client->get($this->baseUrl . '/transactions/' . $transactionId . '/verify', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            
            if ($body['status'] === 'success') {
                return [
                    'success' => true,
                    'data' => $body['data']
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? 'Payment verification failed'
            ];

        } catch (RequestException $e) {
            Log::error('Flutterwave payment verification failed', [
                'error' => $e->getMessage(),
                'transaction_id' => $transactionId
            ]);

            return [
                'success' => false,
                'message' => 'Payment verification unavailable'
            ];
        }
    }

    /**
     * Create a payment plan for recurring subscriptions
     */
    public function createPaymentPlan(array $planData)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/payment-plans', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'amount' => $planData['amount'],
                    'name' => $planData['name'],
                    'interval' => $planData['interval'], // monthly, yearly
                    'duration' => $planData['duration'] ?? 0, // 0 for unlimited
                    'currency' => $planData['currency'] ?? 'KES',
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            
            if ($body['status'] === 'success') {
                return [
                    'success' => true,
                    'data' => $body['data']
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? 'Payment plan creation failed'
            ];

        } catch (RequestException $e) {
            Log::error('Flutterwave payment plan creation failed', [
                'error' => $e->getMessage(),
                'plan_data' => $planData
            ]);

            return [
                'success' => false,
                'message' => 'Payment plan service unavailable'
            ];
        }
    }

    /**
     * Subscribe customer to a payment plan
     */
    public function subscribeCustomer(array $subscriptionData)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/payment-plans/' . $subscriptionData['plan_id'] . '/subscriptions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'customer' => $subscriptionData['customer']['email'],
                    'plan_token' => $subscriptionData['plan_token'] ?? null,
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            
            if ($body['status'] === 'success') {
                return [
                    'success' => true,
                    'data' => $body['data']
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? 'Subscription creation failed'
            ];

        } catch (RequestException $e) {
            Log::error('Flutterwave subscription creation failed', [
                'error' => $e->getMessage(),
                'subscription_data' => $subscriptionData
            ]);

            return [
                'success' => false,
                'message' => 'Subscription service unavailable'
            ];
        }
    }

    /**
     * Cancel a subscription
     */
    public function cancelSubscription($subscriptionId)
    {
        try {
            $response = $this->client->put($this->baseUrl . '/subscriptions/' . $subscriptionId . '/cancel', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            
            if ($body['status'] === 'success') {
                return [
                    'success' => true,
                    'data' => $body['data']
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? 'Subscription cancellation failed'
            ];

        } catch (RequestException $e) {
            Log::error('Flutterwave subscription cancellation failed', [
                'error' => $e->getMessage(),
                'subscription_id' => $subscriptionId
            ]);

            return [
                'success' => false,
                'message' => 'Subscription cancellation unavailable'
            ];
        }
    }

    /**
     * Get public key for frontend integration
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}
