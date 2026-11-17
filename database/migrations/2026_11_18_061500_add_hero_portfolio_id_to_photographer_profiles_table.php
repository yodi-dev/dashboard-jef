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
        Schema::table('photographer_profiles', function (Blueprint $table) {
            $table->foreignId('hero_portfolio_id')->nullable()->after('hero_position')->constrained('portfolios')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photographer_profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('hero_portfolio_id');
        });
    }
};
