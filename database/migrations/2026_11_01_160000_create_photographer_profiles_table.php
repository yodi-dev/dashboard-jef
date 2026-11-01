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
        Schema::create('photographer_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Jef Lee');
            $table->string('tagline')->default('Portrait & Documentary Photographer');
            $table->string('headline')->default('Telling honest stories through natural light and quiet moments.');
            $table->text('sub_headline')->nullable();
            $table->text('quote')->nullable();
            $table->string('about_title')->default('Documenting the quiet cadence of ordinary life.');
            $table->text('about_journey')->nullable();
            $table->text('about_philosophy')->nullable();
            $table->string('philosophy_1_title')->default('Natural Ambient Light');
            $table->text('philosophy_1_desc')->nullable();
            $table->string('philosophy_2_title')->default('The Unrehearsed Moment');
            $table->text('philosophy_2_desc')->nullable();
            $table->string('philosophy_3_title')->default('Archival Craftsmanship');
            $table->text('philosophy_3_desc')->nullable();
            $table->string('avatar')->nullable();
            $table->string('location')->default('Australia / Kyoto, Japan');
            $table->string('email')->default('jef@example.com');
            $table->string('phone')->default('+61 400 123 456');
            $table->string('instagram')->default('@jeflee');
            $table->string('instagram_url')->default('https://instagram.com/jeflee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photographer_profiles');
    }
};

