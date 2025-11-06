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
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ministry_id');
            $table->string('type')->default('event'); // event, workshop, training, course, etc
            $table->string('programmeCode')->unique();
            $table->string('title');
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->time('startTime')->nullable();
            $table->time('endTime')->nullable();
            $table->dateTime('activeUntil')->nullable();
            $table->string('customDate')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('country')->nullable();
            $table->string('latLong')->nullable();
            $table->decimal('price', 8,2)->default(0);
            $table->decimal('adminFee', 8,2)->default(0);
            $table->string('thumb')->nullable();
            $table->string('a3_poster')->nullable();
            $table->string('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('contactNumber')->nullable();
            $table->string('contactPerson')->nullable();
            $table->string('contactEmail')->nullable();
            $table->string('chequeCode')->nullable();
            $table->integer('limit')->default(0);
            $table->text('settings')->nullable();
            $table->text('extraFields')->nullable();
            $table->boolean('searchable')->default(true);
            $table->boolean('publishable')->default(true);
            $table->boolean('private_only')->default(false);
            $table->string('externalUrl')->nullable();
            $table->boolean('soft_delete')->default(false);
            $table->boolean('allowPreRegistration')->default(false);
            $table->boolean('allowWalkInRegistration')->default(false);
            $table->boolean('allowGroupRegistration')->default(false);
            $table->integer('groupRegistrationMin')->nullable();
            $table->integer('groupRegistrationMax')->nullable();
            $table->decimal('groupRegIndividualFee', 8, 2)->nullable();
            $table->boolean('allowBreakoutSession')->default(false);
            $table->string('status')->nullable('draft'); // draft, published, for private
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programmes');
    }
};
