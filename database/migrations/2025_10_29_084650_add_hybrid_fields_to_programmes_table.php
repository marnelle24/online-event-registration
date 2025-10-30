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
        Schema::table('programmes', function (Blueprint $table) {
            $table->boolean('isHybridMode')->default(false)->after('allowBreakoutSession');
            $table->text('hybridPlatformDetails')->nullable()->after('isHybridMode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropColumn(['isHybridMode', 'hybridPlatformDetails']);
        });
    }
};