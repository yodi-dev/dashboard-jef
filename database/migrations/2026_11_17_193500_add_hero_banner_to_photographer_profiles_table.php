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
            $table->string('hero_image')->nullable()->after('quote');
            $table->string('hero_position')->default('center')->after('hero_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photographer_profiles', function (Blueprint $table) {
            $table->dropColumn(['hero_image', 'hero_position']);
        });
    }
};
