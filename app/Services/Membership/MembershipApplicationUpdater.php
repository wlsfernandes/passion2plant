<?php

namespace App\Services\Membership;

use App\Models\MembershipApplication;

class MembershipApplicationUpdater
{
  /**
   * Mark application as started (checkout initiated)
   */
  public static function markAsStarted(
    MembershipApplication $application,
    string $sessionId = null
  ): MembershipApplication {

    $application->update([
      'checkout_session_id' => $sessionId,
      'status' => 'started',
      'started_at' => now(),
    ]);

    return $application;
  }



  /**
   * Mark application as paid.
   */
  public static function markAsPaid(
    MembershipApplication $application,
    string $subscriptionId,
    ?string $paymentEmail = null,
    ?int $memberId = null
  ): MembershipApplication {

    $application->update([
      'status' => 'paid',
      'subscription_id' => $subscriptionId,
      'paid_at' => now(),
      'payment_email' => $paymentEmail,
      'member_id' => $memberId,
    ]);

    return $application;
  }
}
