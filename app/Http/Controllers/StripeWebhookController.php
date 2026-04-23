<?php

namespace App\Http\Controllers;

use App\Events\PaymentCompleted;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Membership\MembershipPaymentService;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Stripe\Webhook;

class StripeWebhookController extends BaseController
{
    protected MembershipPaymentService $membershipService;

    public function __construct(MembershipPaymentService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );

            SystemLogger::log(
                'Stripe webhook received and verified',
                'info',
                'webhooks.stripe.received',
                [
                    'event_id' => $event->id,
                    'event_type' => $event->type,
                ]
            );

        } catch (\Throwable $e) {

            SystemLogger::log(
                'Stripe webhook signature verification failed',
                'error',
                'webhooks.stripe.invalid_signature',
                [
                    'exception' => $e->getMessage(),
                ]
            );

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        try {

            // ✅ ONLY process what you need
            if ($event->type !== 'checkout.session.completed') {

                SystemLogger::log(
                    'Stripe webhook ignored (event not needed)',
                    'info',
                    'webhooks.stripe.ignored',
                    [
                        'event_type' => $event->type,
                    ]
                );

                return response()->json(['status' => 'ignored']);
            }

            // ✅ Process your main event
            $this->handleCheckoutCompleted($event);

        } catch (\Throwable $e) {

            SystemLogger::log(
                'Stripe webhook processing failed',
                'error',
                'webhooks.stripe.failed',
                [
                    'event_type' => $event->type ?? null,
                    'exception' => $e->getMessage(),
                ]
            );

            // ⚠️ VERY IMPORTANT → NEVER return 500
            return response()->json(['error' => 'Webhook failed'], 200);
        }

        return response()->json(['status' => 'ok']);
    }

    protected function handleCheckoutCompleted($event): void
    {
        $session = $event->data->object;
        $type = $session->metadata->type ?? null;
        match ($type) {
            'donation' => $this->processDonation($session),
            'cart' => $this->processCart($session),
            'membership' => $this->processMembership($session),
            default => null,
        };
    }

    protected function processMembership($session): void
    {
        // -----------------------------------------
        // 1️⃣ Extract metadata returned from Stripe and resolve application
        // -----------------------------------------
        $applicationId = $session->metadata->application_id ?? null;
        $subscriptionId = $session->subscription ?? null;
        $paymentEmail = $session->customer_details->email ?? $session->customer_email ?? null;

        if (! $applicationId || ! $subscriptionId) {
            throw new \Exception('Missing application_id or subscription_id from Stripe session.');
        }
        // -----------------------------------------
        // 2️⃣  Call Service MemberSubscriptionService: To Create/Renew User Membership, update application status, and record payment
        // -----------------------------------------
        $member = $this->membershipService->processMembership([
            'application_id' => $applicationId,
            'subscription_id' => $subscriptionId,
            'payment_email' => $paymentEmail,
        ]);
    }

    /**
     * Display a listing of memberships.
     */
    protected function processDonation($session): void
    {
        try {
            SystemLogger::log(
                'Processing donation payment',
                'info',
                'payments.donation.processing',
                [
                    'session_id' => $session->id,
                ]
            );

            $payableId = $session->metadata->payable_id ?? null;
            $payment = Payment::create([
                // ----------------------------------
                // What this payment is for
                // ----------------------------------
                'payable_type' => Donation::class,
                'payable_id' => (int) $payableId,

                // ----------------------------------
                // Stripe references
                // ----------------------------------
                'stripe_session_id' => $session->id,
                'stripe_payment_intent_id' => $session->payment_intent ?? null,
                'stripe_customer_id' => $session->customer ?? null,

                // ----------------------------------
                // Payment details
                // ----------------------------------
                'payment_type' => 'one_time',
                'status' => 'completed',

                // Stripe sends amount in cents
                'amount' => $session->amount_total,
                'currency' => $session->currency,

                // ----------------------------------
                // Customer snapshot
                // ----------------------------------
                'email' => $session->customer_email,
                'first_name' => $session->metadata->first_name ?? null,
                'last_name' => $session->metadata->last_name ?? null,
                'country' => $session->metadata->country ?? null,
                'address' => $session->metadata->address ?? null,

                // ----------------------------------
                // Meta / audit
                // ----------------------------------
                'metadata' => $session->metadata,
                'paid_at' => now(),
            ]);

            // send email notification (wrapped in...)
            try {
                $payload = [
                    'email' => $session->customer_email,
                    'name' => trim($session->metadata->first_name ?? '') ?: 'Friend',
                    'amount' => number_format($session->amount_total / 100, 2),
                    'currency' => strtoupper($session->currency ?? 'USD'),
                ];

                try {
                    event(new PaymentCompleted('donation', $payload));
                } catch (\Throwable $e) {
                    SystemLogger::log(
                        'Failed to dispatch PaymentCompleted event',
                        'error',
                        'events.payment_completed.failed',
                        [
                            'exception' => $e->getMessage(),
                            'payment_id' => $payment->id,
                        ]
                    );
                }

            } catch (\Throwable $e) {
                SystemLogger::log(
                    'Failed to dispatch PaymentCompleted event',
                    'error',
                    'events.payment_completed.failed',
                    [
                        'exception' => $e->getMessage(),
                        'payment_id' => $payment->id,
                    ]
                );
            }

            // ✅ SUCCESS LOG
            SystemLogger::log(
                'Donation payment recorded successfully',
                'info',
                'payments.donation.completed',
                [
                    'payment_id' => $payment->id,
                    'donation_id' => $session->metadata->donation_id ?? null,
                    'stripe_session_id' => $session->id,
                    'stripe_payment_intent' => $session->payment_intent ?? null,
                    'amount' => $session->amount_total,
                    'currency' => $session->currency,
                    'email' => $session->customer_email,
                ]
            );

        } catch (\Throwable $e) {

            // ❌ FAILURE LOG (VERY IMPORTANT FOR WEBHOOK DEBUGGING)
            SystemLogger::log(
                'Donation payment processing failed',
                'error',
                'payments.donation.failed',
                [
                    'exception' => $e->getMessage(),
                    'stripe_session_id' => $session->id ?? null,
                    'stripe_payment_intent' => $session->payment_intent ?? null,
                    'donation_id' => $session->metadata->donation_id ?? null,
                    'email' => $session->customer_email ?? null,
                    'payload' => $session,
                ]
            );

            // ❗ DO NOT throw again
            // Stripe webhooks must still return 200 to avoid retries
        }
    }

    /*  * Process a completed checkout session for a cart purchase
     * @param object $session The Stripe checkout session object
     * @return void
     */

    protected function processCart($session): void
    {
        try {

            SystemLogger::log(
                'Processing cart payment',
                'info',
                'payments.cart.processing',
                [
                    'session_id' => $session->id,
                ]
            );
            // ----------------------------------
            // Idempotency
            // ----------------------------------
            if (Payment::where('stripe_session_id', $session->id)->exists()) {
                SystemLogger::log(
                    'Cart payment already recorded (duplicate webhook ignored)',
                    'info',
                    'payments.cart.duplicate',
                    [
                        'stripe_session_id' => $session->id,
                    ]
                );

                return;
            }

            // ----------------------------------
            // Decode cart safely
            // ----------------------------------
            $cart = [];

            if (! empty($session->metadata->cart)) {
                $cart = json_decode($session->metadata->cart, true) ?? [];
            }

            if (empty($cart)) {
                throw new \Exception('Cart metadata is empty or invalid.');
            }

            $shipping = (int) round(((float) ($session->metadata->shipping ?? 0)) * 100);

            $subtotal = collect($cart)->sum(function ($item) {
                return (int) ($item['price'] * 100) * (int) $item['quantity'];
            });

            // ----------------------------------
            // Create Payment + Order + Order Items
            // ----------------------------------

            $payment = Payment::create([
                // Polymorphic target (temporary until order exists)
                'payable_type' => null,
                'payable_id' => null,

                // Stripe references
                'stripe_session_id' => $session->id,
                'stripe_payment_intent_id' => $session->payment_intent ?? null,
                'stripe_customer_id' => $session->customer ?? null,

                // Payment info
                'payment_type' => 'one_time',
                'status' => 'completed',

                // Amounts are stored in cents
                'amount' => $session->amount_total,
                'currency' => $session->currency,

                // Customer snapshot
                'email' => $session->customer_email,
                'first_name' => $session->metadata->first_name ?? null,
                'last_name' => $session->metadata->last_name ?? null,
                'country' => $session->metadata->country ?? null,
                'address' => $session->metadata->address ?? null,

                'metadata' => $session->metadata,
                'paid_at' => now(),
            ]);

            $order = Order::create([
                'status' => 'paid',
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $session->amount_total,
                'currency' => $session->currency,

                'email' => $session->customer_email,
                'first_name' => $session->metadata->first_name ?? null,
                'last_name' => $session->metadata->last_name ?? null,
                'country' => $session->metadata->country ?? null,
                'address' => $session->metadata->address ?? null,

                'metadata' => $session->metadata,
            ]);

            // ----------------------------------
            // Order Items
            // ----------------------------------
            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'price' => (int) ($item['price'] * 100),
                    'quantity' => (int) $item['quantity'],
                    'currency' => $item['currency'],
                ]);
            }
            /* send email notification (wrapped in...) */

            try {
                $payload = [
                    'email' => $session->customer_email,
                    'name' => trim(($session->metadata->first_name ?? '').' '.($session->metadata->last_name ?? '')),
                    'amount' => number_format($session->amount_total / 100, 2),
                    'currency' => strtoupper($session->currency ?? 'USD'),
                    // Optional but useful
                    'order_id' => $order->id ?? null,
                    'items' => collect($cart)->map(fn ($item) => $item['name'].' × '.$item['quantity']
                    )->toArray(),
                ];
                event(new PaymentCompleted('cart', $payload));

            } catch (\Throwable $e) {
                SystemLogger::log(
                    'Failed to dispatch PaymentCompleted event',
                    'error',
                    'events.payment_completed.failed',
                    [
                        'exception' => $e->getMessage(),
                        'payment_id' => $payment->id,
                    ]
                );
            }
            // ----------------------------------
            // Attach Payment → Order
            // ----------------------------------
            Payment::where('stripe_session_id', $session->id)->update([
                'order_id' => $order->id,
                'payable_type' => Order::class,
                'payable_id' => $order->id,
            ]);

            SystemLogger::log(
                'Order created after cart payment',
                'info',
                'orders.created',
                [
                    'order_id' => $order->id,
                    'items_count' => count($cart),
                    'total' => $session->amount_total,
                ]
            );

        } catch (\Throwable $e) {

            SystemLogger::log(
                'Cart payment processing failed',
                'error',
                'payments.cart.failed',
                [
                    'exception' => $e->getMessage(),
                    'stripe_session_id' => $session->id ?? null,
                    'email' => $session->customer_email ?? null,
                    'payload' => $session,
                ]
            );
        }
    }
}
