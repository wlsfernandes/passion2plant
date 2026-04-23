<?php

namespace App\Services\Membership;

use Illuminate\Http\Request;

/**
 * NormalizerData
 * This class provides static methods to normalize and sanitize membership application input data.
 * It ensures that the data is in a consistent format before being processed by the membership services.
 */
class NormalizerData
{
    /**
     * Normalize membership application input data
     */
    public static function normalizeMembershipInput(Request $request): array
    {
        return [
            'amount' => trim($request->input('amount')) ?: 0,
            'interval' => trim($request->input('interval')) === 'annual' ? 'year' : 'month',
            'email' => trim($request->input('email')) ?: null,
            'first_name' => trim($request->input('first_name')) ?: 'Member',
            'last_name' => trim($request->input('last_name')) ?: '—',
            'address' => trim($request->input('address')) ?: null,
            'country' => trim($request->input('country')) ?: null,
            'city' => trim($request->input('city')) ?: null,
            'state' => trim($request->input('state')) ?: null,
            'postal_code' => trim($request->input('postal_code')) ?: null,
            'phone' => trim($request->input('phone')) ?: null,
            'status' => 'pending',
            'started_at' => now(),
        ];
    }
}
