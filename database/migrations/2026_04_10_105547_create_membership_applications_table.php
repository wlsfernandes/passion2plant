<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();

            // Payment info
            $table->decimal('amount', 10, 2);
            $table->string('interval');

            // User info (snapshot at time of payment)
            $table->string('email');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            // Address
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();

            // Contact
            $table->string('phone')->nullable();

            // Status (pending, paid, failed, refunded, etc.)
            $table->string('status')->default('pending');

            // Dates
            $table->timestamp('started_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->string('checkout_session_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('payment_email')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};
