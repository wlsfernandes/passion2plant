<?php

namespace App\Services\Membership;

use App\Models\MembershipApplication;
use Illuminate\Support\Facades\DB;

class NewMembershipApplication
{
    public static function create(array $data): MembershipApplication
    {
        return DB::transaction(function () use ($data) {

            $payload = [

                'amount' => $data['amount'] ?? 0,
                'interval' => $data['interval'] ?? null,
                'email' => $data['email'] ?? null,
                'first_name' => $data['first_name'] ?? 'Member',
                'last_name' => $data['last_name'] ?? '—',
                'address' => $data['address'] ?? null,
                'country' => $data['country'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'phone' => $data['phone'] ?? null,

                // Status
                'status' => 'draft',
                'started_at' => now(),
            ];

            return MembershipApplication::create($payload);
        });
    }
}
