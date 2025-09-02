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
        Schema::create('breakouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programme_id')->constrained('programmes')->onDelete('cascade');
            $table->string('programCode');
            $table->string('title');
            $table->text('description')->nullable();
            $table->datetime('startDate');
            $table->datetime('endDate');
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('isActive')->default(true);
            $table->integer('order')->default(0);
            $table->foreignId('speaker_id')->constrained('speakers');
            $table->string('location')->nullable();
            $table->string('createdBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakouts');
    }
};
