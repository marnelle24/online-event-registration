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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programme_id')->constrained('programmes')->onDelete('cascade');
            $table->string('programCode');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('startDate');
            $table->date('endDate');
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('isActive')->default(true);
            $table->integer('arrangement')->default(1);
            $table->integer('counter')->default(0);
            $table->string('createdBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
