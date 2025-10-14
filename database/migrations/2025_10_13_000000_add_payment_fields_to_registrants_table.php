<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registrants', function (Blueprint $table) {
            // Payment gateway information
            $table->string('payment_gateway')->nullable()->after('paymentOption');
            $table->string('payment_transaction_id')->nullable()->after('payment_gateway');
            $table->text('payment_metadata')->nullable()->after('payment_transaction_id');
            
            // Bank transfer verification fields
            $table->string('payment_verified_by')->nullable()->after('payment_metadata');
            $table->timestamp('payment_verified_at')->nullable()->after('payment_verified_by');
            
            // Payment timestamps
            $table->timestamp('payment_initiated_at')->nullable()->after('payment_verified_at');
            $table->timestamp('payment_completed_at')->nullable()->after('payment_initiated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'payment_transaction_id',
                'payment_metadata',
                'payment_verified_by',
                'payment_verified_at',
                'payment_initiated_at',
                'payment_completed_at',
            ]);
        });
    }
};

