<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'portfolios_published_index');
            $table->index('is_highlight', 'portfolios_highlight_index');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'articles_published_index');
            $table->index('is_highlight', 'articles_highlight_index');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->index('status', 'bookings_status_index');
            $table->index('booking_date', 'bookings_date_index');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropIndex('portfolios_published_index');
            $table->dropIndex('portfolios_highlight_index');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('articles_published_index');
            $table->dropIndex('articles_highlight_index');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_status_index');
            $table->dropIndex('bookings_date_index');
        });
    }
};
