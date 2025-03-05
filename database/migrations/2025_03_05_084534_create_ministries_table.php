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
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('bio')->nullable();
            $table->string('contactPerson')->nullable();
            $table->string('contactNumber')->nullable();
            $table->string('contactEmail')->nullable();
            $table->string('websiteUrl')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('publishabled')->default(1);
            $table->boolean('searcheable')->default(1);
            $table->string('requestedBy')->nullable();
            $table->string('approvedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ministries');
    }
};
