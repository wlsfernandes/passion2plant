<?php
namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Payment;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Stripe\Webhook;

class StripeWebhookController extends BaseController
{
    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        match ($event->type) {
            'checkout.session.completed' => $this->handleCheckoutCompleted($event),
            default                      => null,
        };

        return response()->json(['status' => 'ok']);
    }

    protected function handleCheckoutCompleted($event): void
    {
        $session = $event->data->object;
        $type    = $session->metadata->type ?? null;
        match ($type) {
            'donation' => $this->processDonation($session),
            default    => null,
        };
    }

    protected function processDonation($session): void
    {
        try {

            $payableId = $session->metadata->payable_id ?? null;
            $payment   = Payment::create([
                // ----------------------------------
                // What this payment is for
                // ----------------------------------
                'payable_type'             => Donation::class,
                'payable_id'               => (int) $payableId,

                // ----------------------------------
                // Stripe references
                // ----------------------------------
                'stripe_session_id'        => $session->id,
                'stripe_payment_intent_id' => $session->payment_intent ?? null,
                'stripe_customer_id'       => $session->customer ?? null,

                // ----------------------------------
                // Payment details
                // ----------------------------------
                'payment_type'             => 'one_time',
                'status'                   => 'completed',

                // Stripe sends amount in cents
                'amount'                   => $session->amount_total,
                'currency'                 => $session->currency,

                // ----------------------------------
                // Customer snapshot
                // ----------------------------------
                'email'                    => $session->customer_email,
                'first_name'               => $session->metadata->first_name ?? null,
                'last_name'                => $session->metadata->last_name ?? null,
                'country'                  => $session->metadata->country ?? null,
                'address'                  => $session->metadata->address ?? null,

                // ----------------------------------
                // Meta / audit
                // ----------------------------------
                'metadata'                 => $session->metadata,
                'paid_at'                  => now(),
            ]);

            // ✅ SUCCESS LOG
            SystemLogger::log(
                'Donation payment recorded successfully',
                'info',
                'payments.donation.completed',
                [
                    'payment_id'            => $payment->id,
                    'donation_id'           => $session->metadata->donation_id ?? null,
                    'stripe_session_id'     => $session->id,
                    'stripe_payment_intent' => $session->payment_intent ?? null,
                    'amount'                => $session->amount_total,
                    'currency'              => $session->currency,
                    'email'                 => $session->customer_email,
                ]
            );

        } catch (\Throwable $e) {

            // ❌ FAILURE LOG (VERY IMPORTANT FOR WEBHOOK DEBUGGING)
            SystemLogger::log(
                'Donation payment processing failed',
                'error',
                'payments.donation.failed',
                [
                    'exception'             => $e->getMessage(),
                    'stripe_session_id'     => $session->id ?? null,
                    'stripe_payment_intent' => $session->payment_intent ?? null,
                    'donation_id'           => $session->metadata->donation_id ?? null,
                    'email'                 => $session->customer_email ?? null,
                    'payload'               => $session,
                ]
            );

            // ❗ DO NOT throw again
            // Stripe webhooks must still return 200 to avoid retries
        }
    }

}
