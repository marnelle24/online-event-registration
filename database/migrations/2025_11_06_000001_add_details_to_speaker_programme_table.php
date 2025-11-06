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
        Schema::table('speaker_programme', function (Blueprint $table) {
            if (!Schema::hasColumn('speaker_programme', 'details')) {
                $table->text('details')->nullable()->after('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('speaker_programme', function (Blueprint $table) {
            if (Schema::hasColumn('speaker_programme', 'details')) {
                $table->dropColumn('details');
            }
        });
    }
};


