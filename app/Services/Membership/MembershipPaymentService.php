<?php

namespace App\Services\Membership;

use App\Mail\SendMembershipWelcome;
use App\Models\MembershipApplication;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
            // 3️⃣ Send email notification
            // -----------------------------------------
            try {
                Mail::to($application->email)
                    ->bcc([
                        'wlsfernandes@gmail.com',
                        'passion2plant@gmail.com',
                        'drlizrios@gmail.com',
                    ])
                    ->send(new SendMembershipWelcome([
                        'first_name' => $application->first_name,
                        'last_name' => $application->last_name,
                        'email' => $application->email,
                    ]));
            
            } catch (\Exception $e) {
                SystemLogger::log(
                    'Failed to send membership welcome email',
                    'error',
                    'mail.membership_welcome.failed',
                    [
                        'exception' => $e->getMessage(),
                        'email' => $application->email,
                    ]
                );
            }

            return $member;
        });
    }
}
