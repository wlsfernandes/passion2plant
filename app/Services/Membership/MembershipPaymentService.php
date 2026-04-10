<?php

namespace App\Services\Membership;

use App\Models\MembershipApplication;
use App\Models\Payment;
use App\Services\Payments\RegisterPaymentMembership;
use Illuminate\Support\Facades\DB;

class MembershipPaymentService
{
    /**
     * @param array{
     *   application_id:int|string,
     *   subscription_id:string,
     *   provider:string,
     *   currency?:string
     * } $data
     */
    public function processMembership(array $data)
    {
        return DB::transaction(function () use ($data) {

            // -----------------------------------------
            // 1️⃣ Resolve Application
            // -----------------------------------------
            $application = MembershipApplication::findOrFail($data['application_id']);

            $membershipService = app(MemberSubscriptionService::class);
            $member = $membershipService->provision($application, $data['payment_email']);

            // -----------------------------------------
            // 2️⃣ Update Application
            // -----------------------------------------
            MembershipApplicationUpdater::markAsPaid(
                $application,
                $data['subscription_id'],
                $data['payment_email'],
                $member?->id,
            );

            // -----------------------------------------
            // 3️⃣ Payment Record
            // -----------------------------------------
        //    $payment = new RegisterPaymentMembership;
        //    $payment->handle($application, $data);

            return $member;
        });
    }
}
