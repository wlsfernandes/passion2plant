<?php

namespace App\Services\Membership;

use App\Models\Member;
use App\Models\Membership;
use App\Models\MembershipApplication;
use App\Models\User;
use App\Services\SystemLogger;
use Carbon\Carbon;

/**
 * MemberSubscriptionService
 * This service handles the provisioning and renewal of user memberships.
 * It ensures that users have the appropriate membership role and manages the creation and updating of membership records.
 */
class MemberSubscriptionService
{
    protected int $membershipRoleId = 17; // AETH Membership

    /**
     * Provision or renew a membership
     */
    public function provision(MembershipApplication $application, string $paymentEmail): Member
    {

        return $this->createOrRenewMember($application, $paymentEmail);
    }

    /**
     * Create or renew membership record
     */
    protected function createOrRenewMember(MembershipApplication $application, string $paymentEmail): Member
    {
        $member = Member::where('email', $paymentEmail)->first();
        if (! $member) {
            return $this->createMember($application, $paymentEmail);
        }

        return $this->renewMember($member, $application, $paymentEmail);
    }

    /**
     * Create new membership
     */
    protected function createMember(MembershipApplication $application, string $paymentEmail): Member
    {
        $interval = $application->interval ?? 'annual'; // default to annual if not set
        // -----------------------------------------
        // 1️⃣ Create Member
        // -----------------------------------------
        $member = Member::create([
            'first_name' => $application->first_name,
            'last_name' => $application->last_name,
            'email' => $application->email,
            'address' => $application->address ?? null,
            'city' => $application->city ?? null,
            'state' => $application->state ?? null,
            'zipcode' => $application->zipcode ?? null,
            'country' => $application->country ?? 'United States',
            'amount' => $application->amount ?? 0.00,
            'membership_start_date' => now(),
            'membership_end_date' => $this->calculateInitialEndDate($interval),
            'active_status' => true,
            'is_recurring' => true,
        ]);

        SystemLogger::log(
            'Membership created',
            'info',
            'membership.created',
            [
                'member_id' => $member->id,
            ]
        );

        return $member;
    }

    /**
     * Renew existing membership
     */
    protected function renewMember(Member $member, $application, string $paymentEmail): Member
    {
        $currentEnd = Carbon::parse($member->membership_end_date);
        $interval = $application->interval ?? 'annual'; // default to annual if not set
        $newEndDate = $this->calculateRenewalEndDate($currentEnd, $interval);

        $member->update([
            'membership_plan' => $application->membership_plan,
            'membership_end_date' => $newEndDate,
            'active_status' => true,
            'is_recurring' => true,
            'amount' => $application->amount ?? 0.00,
        ]);

        SystemLogger::log(
            'Membership renewed',
            'info',
            'membership.renewed',
            [
                'member_id' => $member->id,
                'old_end' => $currentEnd,
                'new_end' => $newEndDate,
            ]
        );

        return $member;
    }

    /**
     * Initial membership end date
     */
    protected function calculateInitialEndDate(string $interval): Carbon
    {
        return $interval === 'annual'
          ? now()->addYear()
          : now()->addMonth();
    }

    /**
     * Renewal membership end date
     */
    protected function calculateRenewalEndDate(Carbon $currentEnd, string $interval): Carbon
    {
        if ($currentEnd->isFuture()) {
            return $interval === 'annual'
              ? $currentEnd->copy()->addYear()
              : $currentEnd->copy()->addMonth();
        }

        return $interval === 'annual'
          ? now()->addYear()
          : now()->addMonth();
    }
}
