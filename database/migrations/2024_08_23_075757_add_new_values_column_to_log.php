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
        Schema::table('log', function (Blueprint $table) {
            if (Schema::hasColumn('log', 'old_values')) {
                $table->text('new_values')->nullable()->after('old_values');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log', function (Blueprint $table) {
            if (Schema::hasColumn('log', 'new_values')) {
                $table->dropColumn('new_values');
            }
        });
    }
};
