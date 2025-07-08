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
        Schema::create('registrants', function (Blueprint $table) {
            $table->id();
            $table->string('regCode')->unique(); // orderNumber
            $table->string('programCode');
            $table->foreignId('programme_id')->constrained('programmes')->onDelete('cascade');
            $table->string('nric')->nullable();
            $table->string('title')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('email')->nullable();
            $table->string('contactNumber')->nullable();
            $table->text('extraFields')->nullable();
            $table->string('paymentStatus')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('discountAmount', 8, 2)->default(0);
            $table->decimal('netAmount', 8, 2)->default(0);
            $table->string('paymentOption')->nullable(); // paynow|card
            $table->string('paymentReferenceNo')->nullable();
            $table->string('regStatus')->nullable();
            $table->string('groupRegistrationID')->nullable();
            $table->unsignedBigInteger('promocode_id')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->boolean('emailStatus')->default(0);
            $table->string('confirmedBy')->nullable();
            $table->string('approvedBy')->nullable();
            $table->date('approvedDate')->nullable();
            $table->boolean('soft_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrants');
    }
};
